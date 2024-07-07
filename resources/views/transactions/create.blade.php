<x-layout>
    <x-slot:title>Create transaction on {{ $account->name }}</x-slot:title>
    <h1 class="w-full text-3xl">Create transaction on {{ $account->name }}</h1>

    <div class="drop-shadow border-gray-200 rounded flex flex-row create-transaction justify-between gap-20">
        <form class="w-full" method="post" action="{{ route('accounts.transactions.store',['account'=>$account]) }}">
            @csrf
            <div class="form-group">
                <label for="account">Account</label>
                <input type="text" id="account" name="account" disabled value="{{ $account->name }}" required>
            </div>
            <div class="form-group">
                <label for="receiver">Receiver</label>
                <input type="text" id="receiver" name="receiver" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" step=".01" required >
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="datetime-local" id="date" name="date" value="{{ now()->toDateTimeLocalString('minute') }}" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text"  id="category" name="category">
            </div>

            <button type="submit">Create transaction</button>
        </form>
    </div>
</x-layout>
