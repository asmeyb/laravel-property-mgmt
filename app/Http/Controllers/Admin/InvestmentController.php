<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Investment; 
use App\Models\User;
use App\Models\Profit;
use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    public function UserInvestmentProperty($slug)
    {
        $property = Property::where('slug', $slug)->withCount(['investments as sold_shares' 
                => function ($query) {
                    $query->select(DB::raw("SUM(share_count)"));
                }])->firstOrFail();
        $available_shares = max(0, $property->total_shares - $property->sold_shares); 

        // $investments = Investment::where('property_id', $property->id)->get(); 
        // $users = User::all(); $profits = Profit::all(); 
        // $deposits = Deposit::all();
        return view('home.frontend.checkout.checkout_page', compact('property', 'available_shares'));
    }
}
