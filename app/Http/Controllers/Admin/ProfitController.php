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

    public function ProfitDischarge(Request $request)
    {
        $property = Property::with(['investments'])->findOrFail($request->property_id);
        $invetments = $property->Investments;
        $investorCount = $invetments->count();

        if ($investorCount === 0) {
            return back()->with(['Message', 'No investors found for this property.', 'alert-type' => 'error']);
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
            return back()->with(['Message', 'No pending profit to discharge for this property.', 'alert-type' => 'info']);
        }

        $discharge = min($monthlyProfit * $investorCount, $remaining);

        $dischargeCents = (int) round($discharge * 100);
        $perInvestorCents = intdiv($dischargeCents, $investorCount);
        $remaindersCents = $dischargeCents % $investorCount;

        DB::transaction(function () use ($invetments, $perInvestorCents, $remaindersCents, $property) {
            foreach ($invetments->values() as $index => $investment) {
                $amountCents = $perInvestorCents + ($index < $remaindersCents ? 1 : 0);
                $amount = $amountCents / 100;

                Profit::create([
                    'investment_id' => $investment->id,
                    'user_id' => $investment->user_id,
                    'property_id' => $investment->property_id,
                    'profit_amount' => $amount,
                    'paid_date' => \Carbon\Carbon::now()->toDateString(),
                    'trx' => strtoupper(Str::random(16)),
                    'status' => 'paid',
                ]);

            }
        });

        $notification = array(
            'message' => 'Profit discharged successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function AdminProfitReport()
    {
        $profits = Profit::with(['property', 'investment', 'user'])
            ->where('status', 'paid')
            ->latest()
            ->get()
            ->groupBy('user_id');

        return view('admin.backend.reports.profit_report', compact('profits'));
    }

    public function ProfitHistory()
    {
        $profits = Profit::with(['property','investment'])
                    ->where('user_id', auth()->id())
                    ->where('status','paid')
                    ->latest('paid_date')->orderBy('id','desc')->get();
        
        $investment = Investment::with('capitalReturn')
                     ->where('user_id', auth()->id())
                     ->whereHas('capitalReturn')
                     ->latest()
                     ->first();

        return view('home.dashboard.profit_history',compact('profits','investment'));  
    }


}