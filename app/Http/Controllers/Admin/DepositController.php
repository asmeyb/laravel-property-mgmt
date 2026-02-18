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
use function PHPUnit\Framework\returnArgument;

class DepositController extends Controller
{
    public function PendingDeposit()
    {
         $pendingDeposits = Deposit::with(['user','property','installment.investment.property'])->where('status','pending')->latest()->get();
        // dd($pendingDeposits);

        return view('admin.backend.deposit.pending_deposit', compact('pendingDeposits'));
    }

    public function ApprovedDeposits()
    {
        
        $approvedDeposits = Deposit::with(['user','property','installment.investment.property'])->where('status','approved')->latest()->get();
        // dd($approvedDeposits);

        return view('admin.backend.deposit.approved_deposit', compact('approvedDeposits'));
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

    public function AdminDepositeStatusUpdate(Request $request , $id){

        $deposit = Deposit::findOrFail($id);
        $action = $request->input('action');

        if ($action === 'approved') {
            $deposit->status = 'approved';

            if ($deposit->installment_id) {
               $installment = Installment::find($deposit->installment_id);
               if ($installment) {
                 $installment->status = 'paid';
                 $installment->paid_time = now();
                 $installment->save();
               }
            } 

        } elseif ($action === 'rejected') {
           $deposit->status = 'rejected';

            if ($deposit->installment_id) {
               $installment = Installment::find($deposit->installment_id);
               if ($installment) {
                 $installment->status = 'due';
                 $installment->paid_time = null;
                 $installment->save();
               }
            } 
        }

        $deposit->save();

        $notification = array(
            'message' => 'Deposti Status updated Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('pending.deposit')->with($notification); 
    }

    public function PendingDownpayment(){

        $installments = Installment::with(['investment.property','investment.user','deposit'])->where('down_payment', '>',0)->where('status','processing')->get();

        return view('admin.backend.downpayment.pending_downpayment',compact('installments'));

    }

    public function InstallmentStatusUpdate(Request $request, $id){

        $installment = Installment::findOrFail($id);
        // $action = $request->input('action');

        if ($installment->status === 'processing') 
        {
            $installment->status = 'paid';
            $installment->paid_time = now();
            $installment->amount += $installment->down_payment; 
            $installment->save();

            // Update the related Deposit status if it exists
            if($installment->deposit){
                $installment->deposit->status = 'approved';
                $installment->deposit->save();
            }
        } 

        // $installment->save();

        $notification = array(
            'message' => 'Downpayment Status updated Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('pending.downpayment')->with($notification);
    }

    public function ApprovedDownpayment(){

        $installments = Installment::with(['investment.property','investment.user','deposit'])->where('down_payment', '>',0)->where('status','paid')->get();

        return view('admin.backend.downpayment.approved_downpayment',compact('installments'));
    }
}
    