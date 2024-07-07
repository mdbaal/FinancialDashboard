<x-layout>
    <x-slot:title>Import Account</x-slot:title>
    <h1 class="w-full text-3xl">Import Account</h1>

    <div class="w-1/2">
        <form class="gap-5 flex flex-col" action="{{ route('createFromFile') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="account_name">Account name</label>
                <input id="account_name" name="account_name" type="text" placeholder="Account name" required>
            </div>
            <div class="form-group">
                <label for="savings_account">Savings account</label>
                <input id="savings_account" name="savings_account" type="checkbox">
            </div>
            <div class="form-group">
                <label for="account_csv">Select CSV file to import from</label>
                <input id="account_csv" name="account_csv" type="file" accept=".csv" required>
            </div>

            <button type="submit">Create new account</button>
        </form>
    </div>
</x-layout>
