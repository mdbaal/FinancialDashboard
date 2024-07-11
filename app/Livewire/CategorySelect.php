<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CategorySelect extends Component
{
    public Transaction $transaction;
    public string $selectedCategory;
    public Collection $categories;


    public function render()
    {
        $this->categories = Category::all();
        $this->selectedCategory = $this->transaction->category;

        return view('livewire.category-select');
    }

    public function setCategory(){
        $this->transaction->update(['category'=> $this->selectedCategory]);
        $account = $this->transaction->account;
        $this->dispatch('updatedCategories');
        $this->dispatch('refresh');
    }
}
