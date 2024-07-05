<x-layout>
    <x-slot:title>{{$account->nane ?? 'Account -'}}</x-slot:title>
    <h1 class="w-full text-3xl">Account</h1>


    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2">
        <table class="w-full text-md text-left">
            <thead class="text-gray-700 uppercase bg-gray-50">
            <tr>
                <th>ID</th>
                <th>Account</th>
                <th>Receiver</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($account->transactions as $transaction)
            <tr>
                <td>{{$transaction->id}}</td>
                <td>{{$transaction->account}}</td>
                <td>{{$transaction->receiver}}</td>
                <td>{{$transaction->description}}</td>
                <td>{{$transaction->amount}}</td>
                <td><a><span class="material-symbols-outlined">edit</span></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
