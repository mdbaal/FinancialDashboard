@php use App\Models\Account; @endphp
<x-layout>
    <x-slot:title>Home</x-slot:title>
    <h1 class="w-full text-3xl">Dashboard</h1>


    <div class="grid grid-cols-1 gap-5 my-5 dashboard-accounts">
        <script type="text/javascript">
            const accounts = @json( Account::all() );
            const transactions = {};
        </script>
        @foreach( Account::all() as $account )
            <script type="text/javascript">
                transactions[ "{{$account->name}}" ] = @json( $account->transactions()->orderBy('date')->get() );
            </script>

            <div class="border-2 border-gray-200 rounded drop-shadow-2xl dashboard-account">
                <h2 class="w-full text-2xl">{{$account->name}}</h2>
                <div id="{{ $account->name }}-chart"></div>
            </div>
        @endforeach

        @vite('resources/js/charts.js')
    </div>


</x-layout>
