<?php
    
    namespace App\Livewire;
    
    use App\Http\Controllers\TransactionController;
    use App\Models\Account;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Collection;
    use Livewire\Component;
    
    class TransactionTable extends Component
    {
        public Account $account;
        public Collection $transactions;
        public array $selectedTransactions;
        public string $bulkCategory = "None";
        
        // Filter variables
        public array $filterYears = [];
        public int $currentFilterYear;
        public array $currentFilterMonth;
        public array $filterMonths = [];
        
        public function render()
        {
            // TODO: Add filter for table. Start with year:all and then year:month, Then within those sort receiver,amount and category
            // Render charts for latest year available for that account
            // If not set use default of latest year
            if (!isset($this->currentFilterYear)) {
                $latestYear = $this->account->transactions()->orderBy('date', 'desc')->first()->date ?? Carbon::now();
                $latestYear = Carbon::createFromFormat('Y-m-d H:i:s', $latestYear)->year;
                
                $this->currentFilterYear = $latestYear;
            }
            
            if (!isset($this->currentFilterMonth)) {
                $this->currentFilterMonth = [0, "Total"];
            }
            
            if ($this->currentFilterMonth[0] == 0)
                $this->transactions = $this->account->transactions()
                    ->whereYear('date', '=', $this->currentFilterYear)
                    ->orderBy('date', 'desc')
                    ->get();
            else
                $this->transactions = $this->account->transactions()
                    ->whereYear('date', '=', $this->currentFilterYear)
                    ->whereMonth('date', '=', $this->currentFilterMonth[0])
                    ->orderBy('date', 'desc')
                    ->get();
            
            
            $this->setFilterYears();
            
            $this->setDistinctMonths();
            
            return view('livewire.transaction-table');
        }
        
        public function massDelete()
        {
            $transactionController = new TransactionController();
            foreach ($this->selectedTransactions as $transaction)
                $transactionController->destroy($this->account, $this->transactions->find($transaction));
            
            $this->selectedTransactions = [];
        }
        
        public function massCategory()
        {
            foreach ($this->selectedTransactions as $transaction) {
                $this->transactions->find($transaction)->update(['category' => $this->bulkCategory]);
            }
            
            $this->selectedTransactions = [];
            $this->bulkCategory = "None";
            $this->dispatch('updatedCategories');
        }
        
        public function refreshChart()
        {
            $this->dispatch('updateTransactions');
            $this->dispatch('refresh');
        }
        
        private function setFilterYears(): void
        {
            $distinctYears = $this->account->transactions()->orderBy('date')->get()->transform(function ($transaction) {
                return ['year' => Carbon::createFromFormat('Y-m-d H:i:s', $transaction->date)->year];
            })->unique('year');
            
            $this->filterYears = [];
            foreach ($distinctYears as $distinctYear)
                $this->filterYears[] = $distinctYear['year'];
        }
        
        private function setDistinctMonths()
        {
            $distinctMonths = $this->account->transactions()
                ->whereYear('date', '=', $this->currentFilterYear)
                ->orderBy('date')
                ->get()
                ->transform(function ($transaction) {
                    return ['month' =>
                        [
                            Carbon::createFromFormat('Y-m-d H:i:s', $transaction->date)->month,
                            ucfirst(Carbon::createFromFormat('Y-m-d H:i:s', $transaction->date)->monthName)
                        ]
                    ];
                })->unique('month');
            
            $this->filterMonths = [];
            foreach ($distinctMonths as $distinctMonth)
                $this->filterMonths[] = $distinctMonth['month'];
        }
    }
