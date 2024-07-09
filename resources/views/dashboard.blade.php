@php use App\Models\Account; @endphp
<x-layout>
    <x-slot:title>Home</x-slot:title>
    <h1 class="w-full text-3xl">Dashboard</h1>

    <div class="grid grid-cols-1 gap-5 my-5 dashboard-accounts">
        @foreach( Account::all() as $account)
        <livewire:dashboard-chart :account="$account" ></livewire:dashboard-chart>
        @endforeach
    </div>

    @prepend('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>const charts = {};</script>
    @endprepend

</x-layout>
