<x-layout>
    <x-slot:title>Piggybank</x-slot:title>
    <h1 class="w-full text-3xl">Piggybank</h1>

    <div>
        Goal name:<br>
        goal amount: <br>
        current saved:
    </div>
    <h2 class="w-full text-2xl">Transaction</h2>
    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2">
        <table class="w-full text-md text-left">
            <thead class="text-gray-700 uppercase bg-gray-50">
            <tr>
                <th>ID</th>
                <th>Transaction</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</x-layout>
