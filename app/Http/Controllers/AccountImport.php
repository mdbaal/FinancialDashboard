<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

class AccountImport extends Controller
{
    public function CreateFromImport(Request $request){
        $accountName = $request->input('account_name');

        // If account already exists return with fail
        if(Account::find($accountName) !== null)
            return redirect()->back()->with('error', 'An account with that name already exists.');

        $savingsAccount = $request->input('savings_account');

        try {
            $csv = $request->file('account_csv')->get();
        }
        catch (FileNotFoundException $e){
            return redirect()->back()->with('error', 'Something went wrong when uploading the file. Please try again later.');
        }

        $transactions = $this->CsvToTransactionsArray($csv);

        $accountNumber = $transactions[0]['IBAN/BBAN'];

        //Get the latest balance after transaction
        $balance = $transactions[count($transactions)-1]['Saldo na trn'];

        $account = Account::create([
            'name' => $accountName,
            'account_number' => $accountNumber,
            'balance' => str_replace(',','.',$balance),
            'savings_account' => (bool) $savingsAccount,
        ]);

        $this->CreateTransactions($account, $transactions);

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    private function CsvToTransactionsArray($csv): array{
        $csv = str_replace("\r",'',$csv);

        $transactions = [];

        $collection = LazyCollection::make(function() use ($csv){
            $data = str_getcsv($csv,"\n");

             foreach($data as $row)
                yield $row;
        });


        $headers = str_getcsv($collection->first());


        $collection->skip(1)->each(function($data) use (&$transactions,$headers){
            $transaction = [];
            $row = str_getcsv($data);

            foreach([0,4,6,7,9,19] as $i){
                $transaction[$headers[$i]] = $row[$i] ;
            }

            $transactions[] = $transaction;
        });

        return $transactions;
    }

    private function CreateTransactions(Account $account, array $transactions): void
    {
        Category::firstOrCreate(['name'=>'None']);

        foreach ($transactions as $transaction){
            $account->transactions()->create([
                'id' => null,
                'account' => $transaction["IBAN/BBAN"],
                'receiver' => $transaction["Naam tegenpartij"],
                'description' => $transaction["Omschrijving-1"],
                'amount' => str_replace(',','.',$transaction["Bedrag"]),
                'amount_after' => str_replace(',','.',$transaction["Saldo na trn"]),
                'category' => 'None',
                'date' => $transaction["Datum"]
            ]);
        }
    }
}
