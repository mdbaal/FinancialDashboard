@php
    use Carbon\Carbon; @endphp
<x-layout>
    <x-slot:title>{{$account->name ?? 'Account -'}}</x-slot:title>
    <h1 class="w-full text-4xl mb-2">Account - {{ $account->name }}</h1>

    <a class="btn btn-edit" href="{{ route('accounts.edit',$account) }}">Edit account</a>

    <button class="btn btn-delete">Delete account</button>

    <h2 class="text-xl mt-5 ">Balance: &euro;{{ $account->balance }}</h2>

    <div class="flex flex-row">
        <a href="{{ route('accounts.transactions.create',$account) }}" class="btn btn-edit">New transaction</a>
    </div>
    <br>
    <h2 class="text-3xl">Transactions</h2>
    <livewire:transaction-table :transactions="$transactions" :account="$account"></livewire:transaction-table>
    <br>

    <h2 class="text-3xl">Biggest expenses</h2>
    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded mt-5 account-mostspent-chart">
        <livewire:most-spent-chart :account="$account"></livewire:most-spent-chart>
    </div>

    <!-- account delete modal -->
    <div class="modal-background">
        <div class="modal delete-modal">
            <div class="modal-header">
                <h2 class="modal-title">Are you sure </h2>
                <span class="material-symbols-outlined modal-close">close</span>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete this account? Deleting the account cannot be reversed.<br>
                    All transaction will be deleted as well.
                </p>
                <br>
                <form method="post" action="{{ route('accounts.destroy',$account) }}">
                    @csrf
                    @method('DELETE')
                    <div class="form-group-row pt-5">
                        <input class="btn btn-caution" type="submit" value="Delete Account">
                        <button type="button" class="modal-close btn btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
    @prepend('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>const charts = {};</script>
    @endprepend
    @vite('resources/js/deletemodal.js')
</x-layout>
