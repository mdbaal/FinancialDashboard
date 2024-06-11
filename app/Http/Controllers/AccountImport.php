<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountImport extends Controller
{
    public function CreateFromImport(Request $request){
        $accountName = $request->input('account_name');

        // If account already exists return with fail
        if(Account::find($accountName) !== null)
            return redirect()->back()->with('failed', 'An account with that name already exists.');

        $savingsAccount = $request->input('savings_account');

        $csv = $request->file('account_csv');

        $transactions = $this->CsvToTransactionsArray($csv);
        $accountNumber = $transactions[0]['IBAN/BBAN'];

        //Get the latest balance after transaction
        $balance = $transactions[count($transactions)-1]['Saldo na trn'];

        Account::create([
            'name' => $accountName,
            'account_number' => $accountNumber,
            'balance' => $balance,
            'savings_account' => $savingsAccount,
        ]);

        // TODO: Add import of transactions

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    private function CsvToTransactionsArray($csv): array{
        $csvArray = str_getcsv($csv,'\n');

        $headers = array_shift($csvArray);
        $transactions = [];
        $needed = [0,4,6,7,9,19];

        foreach($csvArray as $csvLine){
            $data = str_getcsv($csvLine);
            $transaction = [];
            for($i = 0;0 < count($headers);$i++){
                if(in_array($i,$needed) )
                    $transaction[$headers[$i]] = $data[$i];
            }
            $transactions[] = $transaction;
        }

        return $transactions;
    }
}
