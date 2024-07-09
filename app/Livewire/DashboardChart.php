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

    public function render()
    {
        // TODO: Start a view on a month instead of full year view. Add option to switch between year month day view and make the month default.
        //      Hopefully this makes it less slow initially

        // TODO: Make the points in the chart less big or just show points and show details on hover. Makes it easier to see everything.
        // Render charts for latest year available for that account
        // If not set use default of latest year
        if(!isset($this->currentFilterYear)){
            $latestYear = $this->account->transactions()->orderBy('date')->first()->date;
            $latestYear = Carbon::createFromFormat('Y-m-d H:i:s',$latestYear)->year;

            $this->currentFilterYear = $latestYear;
        }

        $this->transactions = $this->account->transactions()->whereYear('date','=',$this->currentFilterYear)->get(['date','amount_after'])->transform(function($transaction){
            $transaction->date =  Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->format('d-m-Y');

            return $transaction;
        })->toArray();

        // Get all filterable years
        $distinctYears = $this->account->transactions()->orderBy('date')->get()->transform(function($transaction){
            return ['year'=>Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->year];
        })->unique('year');


        $this->filterYears = [];
        foreach ($distinctYears as $distinctYear)
            $this->filterYears[] = $distinctYear['year'];



        return view('livewire.dashboard-chart');
    }

    public function refreshChart(){
        // TODO Use this to refresh the data on the chart.
        //      Chart doesn't use the updated data yet. Need to do something with js probably to update that part. :(
        $this->transactions = $this->account->transactions()->whereYear('date','=',$this->currentFilterYear)->get(['date','amount_after'])->transform(function($transaction){
            $transaction->date =  Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->format('d-m-Y');

            return $transaction;
        })->toArray();

        $this->dispatch('refresh-chart-' . $this->account->name,transactions: $this->transactions);
    }

}
