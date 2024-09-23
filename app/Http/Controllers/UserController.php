<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function browseUserInfo(){
        // Get the authenticated user
        $user = Auth::user();
       
        // Get decrypted account number
        $accountNumber = $user->getDecryptedAccountNumber();
        
        // Get user's balance (assuming balance is stored in a 'balance' column in the users table)
        $balance = $user->balance;

        $iban = $user->id;

        // Pass the data to the view
        return view('dashboard', compact('accountNumber', 'balance','iban'));
       
   }
   public function showWithdrawForm()
   {
       $user = Auth::user();
       return view('transactions.withdrawMoney', ['balance' => $user->balance]);
   }
   public function showDepositForm()
   {
       $user = Auth::user();
       return view('transactions.depositMoney', ['balance' => $user->balance]);
   }

   public function withdrawMoney(Request $request)
    {
        // Validate the input
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Get the requested withdrawal amount
        $amount = $request->input('amount');

        // Check if the balance is sufficient
        if ($user->balance < $amount) {
            return back()->withErrors(['error' => 'Insufficient balance to withdraw the requested amount.']);
        }

        // Deduct the amount from the user's balance
        $user->balance -= $amount;
        $user->save(); // Update the user's balance in the database

        return redirect()->route('dashboard')->with('success', 'Withdrawal successful!');
    }

    public function depositMoney(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
    
        $user = Auth::user();
        $user->balance += $request->amount; // Assuming balance is an attribute in the User model
        $user->save();
    
        return redirect()->back()->with('success', 'Deposit successful!');
    }


    public function showSendMoneyForm()
    {
        $user = Auth::user();
        return view('transactions.sendMoney', ['balance' => $user->balance]);
    }


    public function sendMoney(Request $request) {

        $request->validate([
            'account_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);
    
        $user = Auth::user();
    
        // Decrypt the provided account number
        $iban = $request->account_number;
    
        // Find the recipient using the decrypted account number
        $recipient = User::where('id', $iban)->first();
    
        // Check if recipient exists and user has enough balance
        if (!$recipient) {
            return redirect()->back()->withErrors(['account_number' => 'Recipient not found.']);
        }
    
        if ($user->balance < $request->amount) {
            return redirect()->back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        if ($user->id == $recipient->id) {
            return redirect()->back()->withErrors(['amount' => 'You Cant Send To Your self Please Deposit']);
        }
    
        // Use DB::transaction to ensure atomicity
        DB::transaction(function () use ($user, $recipient, $request) {
            // Process the transfer
            $user->balance -= $request->amount;
            $recipient->balance += $request->amount;
    
            $user->save();
            $recipient->save();
        });
    
        return redirect()->back()->with('success', 'Money sent successfully!');
    }
   
}
