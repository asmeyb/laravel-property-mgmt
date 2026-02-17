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

class DepositController extends Controller
{
    public function PendingDeposits()
    {
         $pendingDeposits = Deposit::with(['user','property','installment.investment.property'])->where('status','pending')->latest()->get();
        // dd($pendingDeposits);

        return view('admin.backend.deposit.pending_deposit', compact('pendingDeposits'));
    }

    public function ApprovedDeposits()
    {
        return view('admin.backend.deposit.approved_deposit');
    }

    public function DepositDetails($id)
    {
        $details = Deposit::with(['user','property','installment.investment.property'])->findOrFail($id);
        // dd($deposit);
        $investmentId = optional($details->installment)->investment_id;

        if(!$investmentId){
            return redirect()->back()->with('error', 'Investment details not found for this deposit.');
        }

        $investment = Investment::with(['user','property','installments'])->findOrFail($investmentId);

        return view('admin.backend.deposit.deposit_details', compact('details'));
    }
}
