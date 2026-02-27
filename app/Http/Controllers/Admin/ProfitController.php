<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Installment;
use App\Models\Investment;
use App\Models\Property;
use App\Models\Profit;
use App\Models\Diposit;
use App\Models\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\CapitalReturn;
use App\Models\Withdraw;

class ProfitController extends Controller
{

    public function PendingProfit()
    {

        $properties = Property::with(['investments'])
            ->where('profit_amount', '>', 0)
            ->get();

        $profits = $properties->map(function ($p) {
            $monthlyProfit = (float) $p->profit_amount;
            $repeatTime = max(1, (int) ($p->repeat_time ?? 1));
            $schedule = $p->profit_schedule ?? 'monthly';
            $investorCount = $p->investments->count();

            if (in_array($schedule, ['one-time', 'life-time'])) {
                $plannedTotal = $monthlyProfit * $investorCount;
            } else {
                $plannedTotal = $monthlyProfit * $repeatTime * $investorCount;
            }

            $alreadyPaid = (float) Profit::where('property_id', $p->id)
                ->where('status', 'paid')
                ->sum('profit_amount');

            $remaining = round(max(0, $plannedTotal - $alreadyPaid), 2);

            return (object) [
                'property' => $p,
                'property_id' => $p->id,
                'investor_count' => $investorCount,
                'monthly_profit' => $monthlyProfit,
                'repeat_time' => $repeatTime,
                'schedule' => $schedule,
                'planned_total' => $plannedTotal,
                'already_paid' => $alreadyPaid,
                'remaining_total' => $remaining,
            ];
        })->filter(fn($row) => $row->remaining_total > 0)
            ->values();
        return view('admin.backend.profit.pending_profit', compact('profits'));

    }
    //End Method 

    public function AdminProfitDischarge(Request $request)
    {

        $property = Property::with(['investments'])->findOrFail($request->property_id);
        $investments = $property->investments;
        $investorCount = $investments->count();

        if ($investorCount === 0) {
            return back()->with(['message' => 'No Investors found for this property', 'alert-type' => 'error']);
        }

        $monthlyProfit = (float) $property->profit_amount;
        $repeatTime = max(1, (int) ($property->repeat_time ?? 1));
        $schedule = $property->profit_schedule ?? 'monthly';

        if (in_array($schedule, ['one-time', 'life-time'])) {
            $plannedTotal = $monthlyProfit * $investorCount;
        } else {
            $plannedTotal = $monthlyProfit * $repeatTime * $investorCount;
        }

        $alreadyPaid = (float) Profit::where('property_id', $property->id)
            ->where('status', 'paid')
            ->sum('profit_amount');

        $remaining = round(max(0, $plannedTotal - $alreadyPaid), 2);

        if ($remaining <= 0) {
            return back()->with(['message' => 'All Scheduled profit alrady distributed', 'alert-type' => 'info']);
        }

        $discharge = min($monthlyProfit * $investorCount, $remaining);

        $dischargeCents = (int) round($discharge * 100);
        $perInvestorCents = intdiv($dischargeCents, $investorCount);
        $remainderCents = $dischargeCents % $investorCount;

        DB::transaction(function () use ($investments, $perInvestorCents, $remainderCents, $property) {
            foreach ($investments->values() as $idx => $investment) {
                $amountCents = $perInvestorCents + ($idx < $remainderCents ? 1 : 0);
                $amount = $amountCents / 100;

                Profit::create([
                    'investment_id' => $investment->id,
                    'user_id' => $investment->user_id,
                    'property_id' => $property->id,
                    'profit_amount' => $amount,
                    'paid_date' => \Carbon\Carbon::now()->toDateString(),
                    'status' => 'paid',
                ]);

            }
        });

        $notification = array(
            'message' => 'One period profit discharge succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pending.profit')->with($notification);
    }
    //End Method 

    public function ProfitReport()
    {
        $profits = Profit::with(['property', 'investment', 'user'])->where('status', 'paid')->latest()->get()->groupBy('user_id');
        return view('admin.backend.reports.profit_report', compact('profits'));
    }
    //End Method 


    public function ProfitHistory()
    {

        $profits = Profit::with(['property', 'investment'])
            ->where('user_id', auth()->id())
            ->where('status', 'paid')
            ->latest('paid_date')->orderBy('id', 'desc')->get();

        $investment = Investment::with('capitalReturn')
            ->where('user_id', auth()->id())
            ->whereHas('capitalReturn')
            ->latest()
            ->first();

        return view('home.dashboard.profit_history', compact('profits', 'investment'));
    }
    // End Method


    public function WithdrawMoney()
    {

        $userId = auth()->id();
        $profits = Profit::with(['property'])->where('user_id', $userId)->where('status', 'paid')->get()->groupBy('property_id');

        $withdraws = Withdraw::where('user_id', $userId)->where('status', 'approved')->get()->groupBy('property_id');

        $capitalReturns = CapitalReturn::with(['property'])->where('user_id', $userId)->where('status', 'paid')->get()->groupBy('property_id');

        return view('home.dashboard.withdraw_money', compact('profits', 'withdraws', 'capitalReturns'));
    }
    // End Method

    public function DepositWithdraw(Request $request)
    {

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'withdraw_amount' => 'required',
            'payment_type' => 'required'
        ]);

        $userId = auth()->id();
        $propertyId = $request->property_id;


        $totalProfit = Profit::where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->sum('profit_amount');

        $totalWithdrawn = Withdraw::where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->sum('receivable_amount');

        $availableProfit = $totalProfit - $totalWithdrawn;

        if ($request->receivable_amount > $availableProfit) {
            return back()->with('error', 'Insufficient profit balance for withdrawal');
        }

        Withdraw::create([
            'user_id' => $userId,
            'property_id' => $propertyId,
            'withdraw_amount' => $request->withdraw_amount,
            'charge' => $request->charge,
            'receivable_amount' => $request->receivable_amount,
            'payment_type' => $request->payment_type,
            'trx' => strtoupper(Str::random(12)),
            'status' => 'pending',

        ]);

        $notification = array(
            'message' => 'Withdrawal request submitted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
    // End Method

    public function CapitalReturnWithdraw(Request $request)
    {
        $request->validate([
            'capital_return_id' => 'required|exists:capital_returns,id'
        ]);

        $userId = auth()->id();
        $capitalReturns = CapitalReturn::where('id', $request->capital_return_id)
            ->where('user_id', $userId)
            ->where('status', 'paid')
            ->first();

        if (!$capitalReturns) {
            return redirect()->back()->with('error', 'Invalid capital return or already requestd');
        }
        $capitalReturns->status = 'pending';
        $capitalReturns->save();


        $notification = array(
            'message' => 'Capital request submitted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }
    // End Method

    public function ApprovedWithdraw()
    {
        $withdraws = Withdraw::with(['user','property'])
                ->where('status','approved')
                ->latest()
                ->get();
        return view('admin.backend.withdraw.approved_withdraw',compact('withdraws'));
    }

    public function PendingWithdraw()
    {
        $withdraws = Withdraw::with(['user', 'property'])->where('status', 'pending')
                     ->latest()->get();

        return view('admin.backend.withdraw.pending_withdraw',compact('withdraws'));
    }

    public function DetailWithdraw($id)
    {
        $details = Withdraw::with(['user','property'])->findOrFail($id);

        return view('admin.backend.withdraw.withdraw_details',compact('details'));
    }

    public function WithdrawApprove(Request $request, $id)
    {
        $withdraws = Withdraw::findOrFail($id);
        // $action = $request->input
        $action = $request->input('action');

        if($action === 'approved')
        {
            $withdraws->status = 'approved';
        }
        elseif($action === 'rejected')
        {
            $withdraws->status = 'rejected';
        }

        $withdraws->save();

        $notification = array(
            'message' => 'Withdraw request approved Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('approved.profit.withdraw')->with($notification);
    }

    public function ApprovedCapital()
    {
        $approvedCapital = CapitalReturn::with(['user','property'])->where('status','paid')->get();
        return view('admin.backend.capital_return.approved_capital',compact('approvedCapital')); 
    }

    public function PendingCapitalWithdraw()
    {
        $pendingCapital = CapitalReturn::with(['user','property'])->where('status','pending')->get();
        return view('admin.backend.capital_return.pending_capital',compact('pendingCapital')); 
    }
    

    public function ApproveCapitalWithdraw(Request $request, $id)
    {
        $capital = CapitalReturn::findOrFail($id);
        if ($request->action == 'approved') {
            $capital->status = 'paid';
        } elseif ($request->action == 'rejected') {
            $capital->status = 'pending';
        }

        $capital->save();

        $notification = array(
            'message' => 'CapitalReturn request Approved Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('approved.capital.withdraw')->with($notification); 
    }

}