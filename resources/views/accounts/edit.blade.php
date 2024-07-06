<x-layout>
    <x-slot:title>Edit account</x-slot:title>
    <h1 class="w-full text-3xl">Edit account - {{ $account->name }}</h1>

    <div class="drop-shadow border-gray-200 rounded edit-account">
        <form class="w-full" method="post" action="{{ route('accounts.update',$account) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="account">Account</label>
                <input type="text" id="account" name="account" value="{{ $account->name}}">
            </div>
            <div class="form-group">
                <label for="account_number">Account Number</label>
                <input type="text" id="account_number" name="account_number" value="{{ $account->account_number}}">
            </div>
            <div class="form-group">
                <label for="balance">Balance</label>
                <input type="number" id="balance" name="balance" step=".01" value="{{ $account->balance}}" disabled>
            </div>
            <div class="form-group">
                <label for="savings">Savings Account</label>
                @if ( $account->savings_account )
                    <input type="checkbox" id="savings" name="savings" checked>
                @else
                    <input type="checkbox" id="savings" name="savings">
                @endif
            </div>

            <button type="submit">Edit account</button>
        </form>
    </div>
</x-layout>
