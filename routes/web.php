<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Info',  [UserController::class, 'browseUserInfo'])->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

    Route::get('/send-money', [UserController::class, 'showSendMoneyForm'])->name('sendMoney.form');
    Route::post('/send-money', [UserController::class, 'sendMoney'])->name('send.money');
 




    
    Route::get('/deposit', [UserController::class, 'showDepositForm'])->name('depositMoney.form');
    Route::post('/deposit', [UserController::class, 'depositMoney'])->name('deposit.money');

    Route::get('/withdraw', [UserController::class, 'showWithdrawForm'])->name('withdrawMoney.form');
    Route::post('/withdraw', [UserController::class, 'withdrawMoney'])->name('withdraw.money');

});

require __DIR__.'/auth.php';
