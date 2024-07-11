@php use App\Models\Category;use Carbon\Carbon; @endphp


<div class="w-full drop-shadow-xl border-2 border-gray-200 rounded mt-5 account-transactions">
    <div>
        <select wire:model="bulkCategory" wire:change="massCategory">
            @foreach( Category::all() as $category )
                <option>{{ $category->name }}</option>
            @endforeach
        </select>

        <button class="btn btn-edit" wire:click="massDelete"
                wire:confirm="Are you sure you want to delete selected transactions?">Delete selected
        </button>
    </div>
    <table class="w-full text-md text-left transactions-table">
        <thead class="text-gray-700 uppercase bg-gray-50">
        <tr>
            <th class="text-sm"></th>
            <th>Account</th>
            <th>Receiver</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Amount After</th>
            <th>Category</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $transactions as $transaction)
            <tr>
                <td><input wire:model="selectedTransactions" value="{{ $transaction->id }}" type="checkbox"></td>
                <td>{{ $transaction->account }}</td>
                <td>{{ $transaction->receiver }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->amount_after }}</td>
                <td>
                    <livewire:category-select :transaction="$transaction"></livewire:category-select>
                </td>
                <td> {{ Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->format('d-m-Y') }} </td>
                <td>
                    <a href="{{ route('accounts.transactions.edit',['account'=> $account,'transaction' => $transaction]) }}"><span
                            class="material-symbols-outlined btn-edit">edit</span></a></td>
                <td>
                    <form method="post"
                          action="{{ route('accounts.transactions.destroy',['account'=>$account,'transaction'=> $transaction]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete-small"><span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
