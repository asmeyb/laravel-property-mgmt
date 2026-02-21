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
use App\Models\CapitalReturn;
use App\Models\Deposit;
use App\Models\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManageInvestmentController extends Controller
{
    public function AllInvestment()
    {
        $properties = Property::whereHas('investments', function ($q) {
            $q->where('payment_status', '!=', 'failed')
                ->where('status', 'active');
        })
            ->with([
                'investments' => function ($q) {
                    $q->where('payment_status', '!=', 'failed')
                        ->where('status', 'active')
                        ->with(['user', 'installments']);
                }
            ])
            ->get()
            ->sortByDesc('created_at')
            ->values();
        return view('admin.backend.investment.all_investment', compact('properties'));
    }
    // End Method

    public function RunningInvestment()
    {
        $properties = Property::whereHas('investments', function ($q) {
            $q->where('payment_status', '!=', 'failed')
                ->where('status', 'active');
        })
            ->with([
                'investments' => function ($q) {
                    $q->where('payment_status', '!=', 'failed')
                        ->where('status', 'active')
                        ->with(['user', 'installments']);
                }
            ])
            ->get()
            ->filter(function ($property) {

                $soldShares = $property->investments->sum('share_count');

                // Return only if shares are still avaibable
                return $soldShares < $property->total_share;

            })
            ->sortByDesc('created_at')
            ->values();


        // $investments = Investment::with(['property','user'])->where('status','active')->latest()->get();
        return view('admin.backend.investment.running_investment', compact('properties'));
    }
    // End Method

    public function CompleteInvestment()
    {
        $properties = Property::whereHas('investments', function ($q) {
            $q->where('payment_status', '!=', 'failed')
                ->where('status', 'active');
        })
            ->with([
                'investments' => function ($q) {
                    $q->where('payment_status', '!=', 'failed')
                        ->where('status', 'active')
                        ->with(['user', 'installments']);
                }
            ])
            ->get()
            ->filter(function ($property) {

                $soldShares = $property->investments->sum('share_count');

                // Return only if shares are still avaibable
                return $soldShares >= $property->total_share;

            })
            ->sortByDesc('created_at')
            ->values();
        //$investments = Investment::with(['property', 'user'])->where('status', 'completed')->latest()->get();
        return view('admin.backend.investment.complete_investment', compact('properties'));
    }

    public function AdminPropertyDetails($id)
    {
        $investment = Investment::with(['property', 'user'])->findOrFail($id);
        $allInvestments = Investment::with(['property', 'user', 'installments'])
            ->where('property_id', $investment->property_id)
            ->where('payment_status', '!=', 'failed')
            ->where('status', 'active')
            ->get();
        return view('admin.backend.investment.property_details', compact('allInvestments', 'investment'));
    }

    public function UserPayHistory($id)
    {
        $investment = Investment::with(['property', 'user','installments'])->findOrFail($id);
        // $installments = Installment::where('investment_id', $id)->latest()->get();
        return view('admin.backend.investment.user_pay_history', compact('investment'));
    }

    public function AdminCapitalBack($investmentId)
    {
        DB::beginTransaction();
        try {
            $investment = Investment::with('property')->findOrFail($investmentId);

            // Check if capital back is already done
            if ($investment->capitalReturn) {
                return back()->with('error', 'Capital back has already returned to this user.');
            }

            $property = $investment->property;

            if(!$property->per_share_amount || $property->per_share_amount <= 0) {
                return back()->with('error', 'Per Share amount is not defined for this property.');
            }

            CapitalReturn::create([
                'investment_id' => $investment->id,
                'user_id' => $investment->user_id,
                'property_id' => $investment->property_id,
                'amount' => $investment->share_count * $property->per_share_amount,
                'paid_date' => now(),
                'trx' => strtoupper(Str::random(16)),
                'status' => 'paid',
            ]);


            DB::commit();

            $notification = array(
                'message' => 'Capital return to the user processed successfully.',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing capital back: ' . $e->getMessage());
        }
        // return view('admin.backend.investment.capital_back', compact('investment'));
    }
}
