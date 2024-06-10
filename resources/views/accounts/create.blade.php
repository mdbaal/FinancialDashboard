<x-layout>
    <x-slot:title>Create new account</x-slot:title>
    <h1 class="w-full text-3xl">Create account</h1>

    <div class="drop-shadow border-gray-200 rounded flex flex-row create-account justify-between gap-20">
        <form class="w-full" method="post" action="{{ route('accounts.store') }}">
            @csrf
            <div class="form-group">
                <label for="account">Account</label>
                <input type="text" id="account" name="account">
            </div>
            <div class="form-group">
                <label for="account_number">Account Number</label>
                <input type="text" id="account_number" name="account_number">
            </div>
            <div class="form-group">
                <label for="Balance">Balance</label>
                <input type="number" id="Balance" name="Balance" step=".01" >
            </div>
            <div class="form-group">
                <label for="savings">Savings Account</label>
                <input type="checkbox" id="savings" name="savings">
            </div>

            <button type="submit">Create account</button>
        </form>
        <h2 class="text-2xl w-1/2 text-center">OR</h2>
        <div class="w-full import-account">
            <a class="" href="{{ route('import') }}"><span class="material-symbols-outlined">upload_file</span>Import account</a>
        </div>
    </div>
</x-layout>
