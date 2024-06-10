<x-layout>
    <x-slot:title>Piggybanks</x-slot:title>
    <h1 class="w-full text-3xl">Piggybanks</h1>

    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2 mt-5">
        <table class="w-full text-md text-left">
            <thead class="text-gray-700 uppercase bg-gray-50">
            <tr>
                <th>Account</th>
                <th>Piggybank</th>
                <th>Balance</th>
                <th>Savings Goal</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <tr class="odd:bg-gray-300">
                <td class="text-blue-700 underline"><a href="#">Spaarrekening</a></td>
                <td>New car</td>
                <td class="align-middle">&euro; 200,-</td>
                <td class="align-middle">&euro; 5000,-</td>
                <td class="text-blue-700"><a href="#"><span class="material-symbols-outlined">edit</span></a></td>
            </tr>
            <tr class="odd:bg-gray-300">
                <td class="text-blue-700 underline"><a href="#">Spaarrekening</a></td>
                <td>New fridge</td>
                <td class="align-middle">&euro; 50,-</td>
                <td class="align-middle">&euro; 200,-</td>
                <td class="text-blue-700"><a href="#"><span class="material-symbols-outlined">edit</span></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</x-layout>
