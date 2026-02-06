<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function UserLogout(Request $request) {
        Auth::guard('web')->logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/login');
    }
     // End Method

     public function MyInvestment(){
        return view('home.dashboard.my_investment');
     }
     // End Method

      public function ProfitHistory(){
        return view('home.dashboard.profit_history');
     }
     // End Method

      public function DepositMoney(){
        return view('home.dashboard.deposit_money');
     }
     // End Method

      public function WithdrawMoney(){
        return view('home.dashboard.withdraw_money');
     }
     // End Method

      public function Transactions(){
        return view('home.dashboard.transactions');
     }
     // End Method

      public function ProfileSetting(){
        return view('home.dashboard.profile_setting');
     }
     // End Method

      public function UserChangePassword(){
        return view('home.dashboard.change_password');
     }
     // End Method



}