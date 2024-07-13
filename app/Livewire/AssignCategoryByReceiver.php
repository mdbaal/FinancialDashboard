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
        public array $selectedReceivers;
        public array $receivers;
        public Collection $categories;
        public string $selectedCategory;
        
        // TODO: Make custom multiselect component
        
        public function render()
        {
            if (!isset($this->selectedAccount))
                $this->selectedAccount = Account::first()->name;
            
            
            $receivers = Account::find($this->selectedAccount)
                ->transactions()
                ->distinct('receiver')
                ->orderBy('receiver')
                ->get('receiver');
            
            $this->selectedReceivers = [];
            
            $this->receivers = [];
            foreach ($receivers->unique('receiver')->toArray() as $receiver)
                $this->receivers[] = $receiver['receiver'];
            
            $this->categories = Category::all();
            $this->selectedCategory = "";
            
            return view('livewire.assign-category-by-receiver', ['accounts' => Account::all()]);
        }
        
        public function assignMass()
        {
            $transactions = Transaction::where('account', '=', $this->selectedAccount)
                ->whereIn('receiver', $this->selectedReceivers)
                ->get();
            
            Category::firstOrCreate(['name' => $this->selectedCategory]);
            
            foreach ($transactions as $transaction) {
                $transaction->category = $this->selectedCategory;
                $transaction->save();
            }
            
            $this->dispatch('refresh');
        }
        
        public function refreshReceivers()
        {
            $this->dispatch('refresh');
        }
    }
