@php use Carbon\Carbon; @endphp
<x-layout>
    <x-slot:title>{{$account->name ?? 'Account -'}}</x-slot:title>
    <h1 class="w-full text-3xl mb-2">Account - {{ $account->name }}</h1>

    <a class="btn btn-edit" href="{{ route('accounts.edit',$account) }}">Edit account</a>

    <button class="btn btn-delete">Delete account</button>

    <h2 class="text-xl mt-5 ">Balance: &euro;{{ $account->balance }}</h2>

    <div class="flex flex-row">
        <a href="{{ route('accounts.transactions.create',$account) }}" class="btn btn-edit">New transaction</a>
    </div>
    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2 mt-5">
        <table class="w-full text-md text-left transactions-table">
            <thead class="text-gray-700 uppercase bg-gray-50">
            <tr>
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
                    <td>{{ $transaction->account }}</td>
                    <td>{{ $transaction->receiver }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->amount_after }}</td>
                    <td>{{ $transaction->category }}</td>
                    <td> {{ Carbon::createFromFormat('Y-m-d H:i:s',$transaction->date)->format('d-m-y H:i') }} </td>
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
    <div class="modal-background">
        <div class="modal delete-modal">
            <div class="modal-header">
                <h2 class="modal-title">Are you sure </h2>
                <span class="material-symbols-outlined modal-close">close</span>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete this account? Deleting the account cannot be reversed.<br>
                    All transaction will be deleted as well.
                </p>
                <br>
                <form method="post" action="{{ route('accounts.destroy',$account) }}">
                    @csrf
                    @method('DELETE')
                    <div class="form-group-row pt-5">
                        <input class="btn btn-caution" type="submit" value="Delete Account">
                        <button type="button" class="modal-close btn btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
    @vite('resources/js/deletemodal.js')
</x-layout>
