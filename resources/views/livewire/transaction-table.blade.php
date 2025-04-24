@php use App\Models\Category;use Carbon\Carbon; @endphp
<div class="w-full mt-5">
    <div class="account-transactions-tools flex flex-row w-full gap-10 my-2">
        <div class="flex flex-row gap-1">
            <select class="rounded">
                <option>2024</option>
            </select>
            <select class="rounded">
                <option>All</option>
            </select>
        </div>
        <div>
            <label>Bulk action</label>
            <select class="rounded">
                <option>--Select Action--</option>
                <option>Delete</option>
                <option>Assign Category</option>
            </select>
        </div>
    </div>
    <div class=" drop-shadow-xl border-2 border-gray-200 rounded  account-transactions">
        <table class="w-full text-md text-left transactions-table">
            <thead class="text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="text-sm"></th>
                    <th>From</th>
                    <th>To</th>
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
                        <td><input wire:model="selectedTransactions" value="{{ $transaction->id }}" type="checkbox">
                        </td>
                        <td>{{ $transaction->sender }}</td>
                        <td>{{ $transaction->receiver }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->amount_after }}</td>
                        <td>
                            <livewire:category-select :$transaction :key="$transaction->id"></livewire:category-select>
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
</div>
