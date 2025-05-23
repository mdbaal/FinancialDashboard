<?php
    
    namespace App\Livewire;
    
    use App\Models\Account;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Livewire\Component;
    
    class MostSpentChart extends Component
    {
        public Account $account;
        public array $transactions;
        public array $filterYears = [];
        public int $currentFilterYear;
        public array $currentFilterMonth;
        public array $filterMonths = [];
        
        protected $listeners = ['updatedCategories' => 'refreshChart'];
        
        public function render()
        {
            // Render charts for latest year available for that account
            // If not set use default of latest year
            if (!isset($this->currentFilterYear)) {
                $latestYear = $this->account->transactions()
                    ->where('amount', '<', '0')
                    ->orderBy('date', 'desc')
                    ->first()
                    ->date ?? Carbon::now();
                
                $latestYear = Carbon::createFromFormat('Y-m-d H:i:s', $latestYear)->year;
                
                $this->currentFilterYear = $latestYear;
            }
            
            if (!isset($this->currentFilterMonth)) {
                
                $this->currentFilterMonth = [0, "Total"];
            }
            
            $this->transactions = $this->getBiggestExpenses();
            
            // Set all filterable years
            $this->setFilterYears();
            
            // Set all filterable months
            $this->setDistinctMonths();
            
            return view('livewire.most-spent-chart');
        }
        
        public function updateFilterMonth()
        {
            $this->currentFilterMonth[1] = ucfirst(Carbon::createFromDate($this->currentFilterYear, $this->currentFilterMonth[0], 1)->monthName);
            
            $this->refreshChart();
        }
        
        public function refreshChart()
        {
            // Get all filterable months
            $this->setDistinctMonths();
            
            if (!in_array($this->currentFilterMonth, $this->filterMonths)) {
                $this->currentFilterMonth = [0, 'Total'];
            }
            
            $this->transactions = $this->getBiggestExpenses();
            
            $this->dispatch('refresh-chart-' . $this->account->name, transactions: $this->transactions);
        }
        
        private function setFilterYears(): void
        {
            $distinctYears = $this->account->transactions()
                ->orderBy('date')
                ->get()
                ->transform(function ($transaction) {
                    return ['year' => Carbon::createFromFormat('Y-m-d H:i:s', $transaction->date)->year];
                })->unique('year');
            
            $this->filterYears = [];
            foreach ($distinctYears as $distinctYear)
                $this->filterYears[] = $distinctYear['year'];
        }
        
        private function setDistinctMonths()
        {
            $distinctMonths = $this->account->transactions()
                ->orderBy('date')
                ->whereYear('date', '=', $this->currentFilterYear)
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
        
        private function getFilteredTransactions(): HasMany
        {
            if ($this->currentFilterMonth[1] === "Total")
                return $this->account->transactions()
                    ->whereYear('date', '=', $this->currentFilterYear);
            else
                return $this->account->transactions()
                    ->whereYear('date', '=', $this->currentFilterYear)
                    ->whereMonth('date', '=', $this->currentFilterMonth[0]);
        }
        
        private function getTotalPerCategory(): array
        {
            $byCategory = [];
            // Get all categories, Change to table of categories later.
            if ($this->currentFilterMonth[1] === "Total")
                $categories = $this->account->transactions()
                    ->where('category', '!=', 'None')
                    ->whereYear('date', '=', $this->currentFilterYear)
                    ->distinct()->get();
            else
                $categories = $this->account->transactions()
                    ->where('category', '!=', 'None')
                    ->whereYear('date', '=', $this->currentFilterYear)
                    ->whereMonth('date', '=', $this->currentFilterMonth[0])
                    ->distinct()->get();
            
            // Loop through and get total per in array like ["car", 100]
            foreach ($categories as $category) {
                $byCategory[$category->category] = abs($this->getFilteredTransactions()
                    ->where('amount', '<', '0')
                    ->where('category', '=', $category->category)
                    ->sum('amount'));
            }
            
            return $byCategory;
        }
        
        
        private function getBiggestExpenses(): array
        {
            $byCategory = $this->getTotalPerCategory();
            
            return collect($byCategory)->sortDesc()->toArray();
        }
    }
