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

class InvestmentController extends Controller
{
    public function UserInvestProperty($slug)
    {
        $property = Property::where('slug', $slug)
            ->withCount([
                'investments as sold_shares' => function ($query) {
                    $query->select(DB::raw('SUM(share_count)'));
                }
            ])
            ->firstOrFail();
        $availableShare = max(0, ($property->total_share - $property->sold_shares));

        return view('home.frontend.checkout.checkout_page', compact('property', 'availableShare'));
    }
    /// End Method 

    public function InvestmentStore(Request $request)
    {

        // Validation 
        if ($request->payment_type === 'installment') {
            $request->validate([
                'down_payment' => 'required|numeric',
                'time_id' => 'required|exists:times,id',
                'total_installment' => 'required'
            ]);
        }

        if ($request->profit_schedule === 'Repeated-Time') {
            $request->validate(['repeat_time' => 'required']);
        }

        $property = Property::findOrFail($request->property_id);

        /// Check avaiable shares
        $soldShares = $property->investments->sum('share_count');
        $availableShare = $property->total_share - $soldShares;

        if ($request->share_count > $availableShare) {
            return back()->with('error', 'Not Enough Shares Available for this property');
        }

        $perShareAmount = $request->per_share_amount;
        $totalAmount = $request->share_count * $perShareAmount;
        $downPayment = 0;
        $installmentAmount = 0;
        $time = null;

        if ($request->payment_type === 'installment') {
            $downPayment = ($request->down_payment / 100) * $totalAmount;
            $remainingAmount = $totalAmount - $downPayment;
            $installmentAmount = $remainingAmount / $request->total_installment;
            $time = Time::findOrFail($request->time_id);
        }

        $paymentStatus = ($request->payment_type === 'full') ? 'paid' : 'pending';
        $transactionId = null;

        // Wrap DB action for invenstment Table 
        DB::transaction(function () use ($request, $property, $perShareAmount, $totalAmount, $downPayment, $installmentAmount, $time, $paymentStatus, $transactionId, ) {
            $investment = Investment::create([
                'user_id' => auth()->id(),
                'property_id' => $property->id,
                'share_count' => $request->share_count,
                'per_share_price' => $perShareAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_type' => $request->payment_type,
                'payment_status' => $paymentStatus,
                'transaction_id' => $transactionId,
                'status' => 'active',
                'approved_by_admin' => ($request->payment_method === 'cash'),
                'investment_date' => now(),
                'time_id' => $request->time_id,
            ]);

            /// Store data in our Installment Table 

            if ($request->payment_type === 'installment') {
                Installment::create([
                    'investment_id' => $investment->id,
                    'amount' => $downPayment,
                    'next_time' => now(),
                    'paid_time' => now(),
                    'status' => 'paid'
                ]);

                for ($i = 1; $i <= $request->total_installment; $i++) {
                    Installment::create([
                        'investment_id' => $investment->id,
                        'amount' => $installmentAmount,
                        'next_time' => now()->addMonths($i * $time->interval_months),
                        'status' => 'due'
                    ]);
                }

            }

            /// add data in Profit table 

            $profitAmount = 0;
            if ($request->profit_type === 'fixed') {
                $profitAmount = $property->profit_amount ?? 0;
            } else {
                $profitAmount = $property->minimum_profit_amount ?? 0;
            }

            $profitAmount *= $request->share_count;

            if ($profitAmount > 0 && $request->profit_schedule === 'Repeated-Time' && $request->repeat_time > 0) {
                for ($i = 1; $i <= $request->repeat_time; $i++) {
                    Profit::create([
                        'investment_id' => $investment->id,
                        'user_id' => auth()->id(),
                        'property_id' => $property->id,
                        'profit_amount' => $profitAmount,
                        'paid_date' => now()->addMonths($i),
                        'status' => 'pending',
                    ]);
                }
            }
        });

        $notification = array(
            'message' => 'Investment Submitted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('my.investment')->with($notification);

    }
    /// End Method 

    public function MyInvestment()
    {

        $investments = Investment::with(['property', 'installments'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        foreach ($investments as $investment) {
            if ($investment->payment_type === 'installment' && $investment->payment_status !== 'paid') {
                $paidAmount = $investment->down_payment + $investment->installments->where('status', 'paid')->sum('amount');
                $investment->due_amount = $investment->total_amount - $paidAmount;
            } else {
                $investment->due_amount = 0;
            }

        }

        return view('home.dashboard.my_investment', compact('investments'));
    }
    // End Method





}