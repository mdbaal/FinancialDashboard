<x-layout>
    <x-slot:title>Edit transaction on {{ $account->name }}</x-slot:title>
    <h1 class="w-full text-3xl">Edit transaction on {{ $account->name }}</h1>

    <div class="drop-shadow border-gray-200 rounded flex flex-row create-transaction justify-between gap-20">
        <form class="w-full" method="post" action="{{ route('accounts.transactions.update',['account' => $account, 'transaction' => $transaction]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="account">Account</label>
                <input type="text" id="account" name="account" disabled value="{{ $transaction->account }}" required>
            </div>
            <div class="form-group">
                <label for="receiver">Receiver</label>
                <input type="text" id="receiver" name="receiver" required value="{{ $transaction->receiver }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" name="description" required value="{{ $transaction->description }}">
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" step=".01" required value="{{ $transaction->amount }}">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="datetime-local" id="date" name="date" value="{{ $transaction->date }}" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text"  id="category" name="category" value="{{ $transaction->category }}">
            </div>

            <button type="submit">Edit transaction</button>
        </form>
    </div>
</x-layout>
