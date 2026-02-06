<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\User\UserController;

Route::get('/', function () {
    return view('home.index');
});

/// Only User Role Access Started

Route::middleware(['auth', IsUser::class])->group(function(){

Route::get('/dashboard', function () {
    return view('home.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); 


 Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');  


Route::controller(UserController::class)->group(function(){
    Route::get('/my/investment', 'MyInvestment')->name('my.investment'); 
    Route::get('/profit/history', 'ProfitHistory')->name('profit.history');
    Route::get('/deposit/money', 'DepositMoney')->name('deposit.money');
    Route::get('/withdraw/money', 'WithdrawMoney')->name('withdraw.money');
    Route::get('/transactions', 'Transactions')->name('transactions');
    Route::get('/profile/setting', 'ProfileSetting')->name('profile.setting');
    Route::get('/user/change/password', 'UserChangePassword')->name('user.change.password');

});



});

/// End User Role Access Started


/// Only Admin Role Access Started

Route::middleware(['auth', IsAdmin::class])->group(function(){

 Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
 Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');  
 Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
 Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');

 Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
 Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');


Route::controller(PropertyController::class)->group(function(){
    Route::get('/all/times', 'AllTimes')->name('all.times');
    Route::get('/add/times', 'AddTimes')->name('add.times');
    Route::post('/store/times', 'StoreTimes')->name('store.times');
    Route::get('/edit/times/{id}', 'EditTimes')->name('edit.times');
    Route::post('/update/times', 'UpdateTimes')->name('update.times');
    Route::get('/delete/times/{id}', 'DeleteTimes')->name('delete.times');

});

Route::controller(PropertyController::class)->group(function(){
    Route::get('/all/location', 'AllLocation')->name('all.location');
    Route::get('/add/location', 'AddLocation')->name('add.location');
    Route::post('/store/location', 'StoreLocation')->name('store.location');
    Route::get('/edit/location/{id}', 'EditLocation')->name('edit.location');
    Route::post('/update/location', 'UpdateLocation')->name('update.location');
    Route::get('/delete/location/{id}', 'DeleteLocation')->name('delete.location');

});


Route::controller(PropertyController::class)->group(function(){
    Route::get('/all/property', 'AllProperty')->name('all.property'); 
    Route::get('/add/property', 'AddProperty')->name('add.property');
    Route::post('/store/property', 'StoreProperty')->name('store.property');
    Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property');
    Route::post('/update/property/{id}', 'UpdateProperty')->name('update.property');
    Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');

    Route::delete('/property/galleryimage-delete/{id}', 'GalleryImgDelete');
});



});

/// End Admin Role Access Started



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 

require __DIR__.'/auth.php';