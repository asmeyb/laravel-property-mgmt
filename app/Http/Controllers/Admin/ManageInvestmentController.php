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
}
