<x-layout>
    <x-slot:title>Accounts</x-slot:title>
    <h1 class="w-full text-3xl">Accounts</h1>

    <a class="bg-blue-400 text-white rounded drop-shadow my-5 block w-fit p-1" href="{{ route('accounts.create') }}">Create account</a>

    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2 mt-5">
        <table class="w-full text-md text-left">
            <thead class="text-gray-700 uppercase bg-gray-50">
            <tr>
                <th>Account</th>
                <th>Account Number</th>
                <th>Balance</th>
                <th>Savings Account</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
             <tr class="odd:bg-gray-300">
                 <td><a href="{{ route('accounts.show',$account) }}">
                         {{ $account->name }}
                     </a>
                 </td>
                 <td>{{ $account->account_number }}</td>
                 <td class="align-middle">&euro; {{ $account->balance }}-</td>
                 <td class="align-middle">
                     @if($account->savings_account)
                     <span class="material-symbols-outlined text-green-500">check</span>
                     @else
                         <span class="material-symbols-outlined text-red-500">cancel</span>
                     @endif
                 </td>
                 <td class="text-blue-700"><a href="#"><span class="material-symbols-outlined">edit</span></a></td>
             </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
