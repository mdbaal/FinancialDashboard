<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('accounts',[
            'accounts' => Account::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if account exists already
        if(Account::where('name', '=', $request->input('account'))->exists())
            return redirect()->back()->with('error','Account with that name already exists.');


        $account = $request->input('account');
        $accountNumber = $request->input('account_number');
        $balance = $request->input('balance');
        $isSavings = $request->input('savings');

        Account::create([
            'name' => $account,
            'account_number' => $accountNumber,
            'balance' => str_replace(',','.',$balance),
            'savings_account' => (bool) $isSavings,
        ]);

        return redirect('accounts')->with('success','Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        $transactions = $account->transactions()->orderBy('date','desc')->get();

        return view('accounts.account',['account'=> $account,'transactions'=> $transactions]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return view('accounts.edit',['account' => $account]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        // If account name has changed. Update all transactions.
        if($request->input('account') !== $account->name) {
            $account->name = $request->input('account');
            $account->save();

            foreach ($account->transactions as $transaction) {
                $transaction->account = $account->name;
                $transaction->save();
            }
        }

        // If any other things have changed update those as well.
        if($request->input('account_number') !== $account->account_number)
            $account->account_number = $request->input('account_number');

        $account->savings_account = (bool)$request->input('savings');

        $account->save();

        return redirect(route('accounts.show',$account->fresh()))->with('success','Updated account successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        /** @var Transaction $transaction */
        foreach ($account->transactions as $transaction){
            $transaction->delete();
        }

        $account->delete();

       return redirect('accounts')->with('success','Account deleted successfully');
    }
}
