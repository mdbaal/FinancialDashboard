<?php

namespace App\Livewire;

use App\Models\Account;
use Carbon\Carbon;
use Livewire\Component;

class DashboardChart extends Component
{
    public Account $account;
    public array $transactions;
    public array $filterYears = [];
    public int $currentFilterYear;
    public array $currentFilterMonth;
    public array $filterMonths = [];

    public function render()
    {
        // Render charts for latest year available for that account
        // If not set use default of latest year
        if(!isset($this->currentFilterYear)){
            $latestYear = $this->account->transactions()->orderBy('date')->first()->date;
            $latestYear = Carbon::createFromFormat('Y-m-d H:i:s',$latestYear)->year;

            $this->currentFilterYear = $latestYear;
        }

        if(!isset($this->currentFilterMonth)){
            $earliestMonth = $this->account->transactions()->orderBy('date')->first()->date;
            $earliestMonth = Carbon::createFromFormat('Y-m-d H:i:s',$earliestMonth);

            $this->currentFilterMonth = [$earliestMonth->month,ucfirst($earliestMonth->monthName)];
        }

        $this->transactions = $this->account->transactions()
            ->whereYear('date','=',$this->currentFilterYear)
            ->whereMonth('date','=',$this->currentFilterMonth[0])
            ->get(['date','amount_after'])
            ->transform(function($transaction){
                $transaction->date =  Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->format('d-m-Y');
                return $transaction;
        }   )->toArray();

        // Get all filterable years
        $distinctYears = $this->account->transactions()->orderBy('date')->get()->transform(function($transaction){
            return ['year'=>Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->year];
        })->unique('year');

        $this->filterYears = [];
        foreach ($distinctYears as $distinctYear)
            $this->filterYears[] = $distinctYear['year'];

        // Get all filterable months
        $distinctMonths = $this->account->transactions()
            ->orderBy('date')
            ->whereYear('date','=',$this->currentFilterYear)
            ->get()
            ->transform(function($transaction){
                return ['month'=>
                    [
                        Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->month,
                        ucfirst(Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->monthName)
                    ]
                ];
            })->unique('month');

        $this->filterMonths = [];
        foreach ($distinctMonths as $distinctMonth)
            $this->filterMonths[] = $distinctMonth['month'];

        return view('livewire.dashboard-chart');
    }

    public function updateFilterMonth(){
        $this->currentFilterMonth[1] = ucfirst(Carbon::createFromDate($this->currentFilterYear,$this->currentFilterMonth[0],1)->monthName);

        $this->refreshChart();
    }

    public function refreshChart(){
        $this->transactions = $this->account->transactions()
            ->whereYear('date','=',$this->currentFilterYear)
            ->whereMonth('date','=',$this->currentFilterMonth[0])
            ->get(['date','amount_after'])
            ->transform(function($transaction){
                $transaction->date =  Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->format('d-m-Y');

                return $transaction;
            })->toArray();

        // Get all filterable months
        $distinctMonths = $this->account->transactions()
            ->orderBy('date')
            ->whereYear('date','=',$this->currentFilterYear)
            ->get()
            ->transform(function($transaction){
                return ['month'=>
                    [
                        Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->month,
                        ucfirst(Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->monthName)
                    ]
                ];
            })->unique('month');

        $this->filterMonths = [];
        foreach ($distinctMonths as $distinctMonth)
            $this->filterMonths[] = $distinctMonth['month'];

        $this->dispatch('refresh-chart-' . $this->account->name,transactions: $this->transactions);
    }

}
