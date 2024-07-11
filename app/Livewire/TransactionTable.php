<?php

namespace App\Livewire;

use App\Http\Controllers\TransactionController;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TransactionTable extends Component
{
    public Account $account;
    public Collection $transactions;
    public array $selectedTransactions;
    public string $bulkCategory = "None";

    public function render()
    {
        return view('livewire.transaction-table');
    }

    public function massDelete(){
        $transactionController = new TransactionController();
        foreach ($this->selectedTransactions as $transaction)
            $transactionController->destroy($this->account,$this->transactions->find($transaction));

        $this->selectedTransactions = [];
    }

    public function massCategory(){
        foreach ($this->selectedTransactions as $transaction) {
            $this->transactions->find($transaction)->update(['category'=> $this->bulkCategory]);
        }

        $this->selectedTransactions = [];
        $this->bulkCategory = "None";
        $this->dispatch('updatedCategories');
    }


}
