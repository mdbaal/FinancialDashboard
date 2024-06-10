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
             <tr class="odd:bg-gray-300">
                 <td>Hoofdrekening</td>
                 <td>NL64RABO1354689</td>
                 <td class="align-middle">&euro; 500,-</td>
                 <td class="align-middle text-green-500"><span class="material-symbols-outlined">check</span></td>
                 <td class="text-blue-700"><a href="#"><span class="material-symbols-outlined">edit</span></a></td>
             </tr>
             <tr class="odd:bg-gray-300">
                 <td>Spaarrekening</td>
                 <td>NL64RABO1354689</td>
                 <td class="align-middle">&euro; 200,-</td>
                 <td class="align-middle text-green-500"><span class="material-symbols-outlined">check</span></td>
                 <td class="text-blue-700"><a href="#"><span class="material-symbols-outlined">edit</span></a></td>
             </tr>
            </tbody>
        </table>
    </div>
</x-layout>
