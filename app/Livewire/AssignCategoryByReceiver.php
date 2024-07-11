<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AssignCategoryByReceiver extends Component
{
    public string $selectedAccount;
    public string $selectedReceiver;
    public array $receivers;
    public Collection $categories;
    public string $selectedCategory;

    public function render()
    {
        $this->selectedAccount = Account::first()->name;
        $this->selectedReceiver = Account::find($this->selectedAccount)->transactions()->first()->receiver;

        $receivers = Account::find($this->selectedAccount)->transactions()->distinct('receiver')->get('receiver')->toArray();

        foreach ($receivers as $receiver)
            $this->receivers[] = $receiver['receiver'];

        $this->categories = Category::all();
        $this->selectedCategory = $this->categories->first();

        return view('livewire.assign-category-by-receiver',['accounts'=>Account::all()]);
    }

    public function assignMass(){
        $transactions = Transaction::where('account','=',$this->selectedAccount)
            ->where('receiver','=',$this->selectedReceiver)
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->category = $this->selectedCategory;
            $transaction->save();
        }

        $this->dispatch('refresh');
    }
}
