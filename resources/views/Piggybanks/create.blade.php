<x-layout>
    <x-slot:title>Create piggybank</x-slot:title>
    <h1 class="w-full text-3xl">Create piggybank</h1>

    <div class="drop-shadow border-gray-200 rounded">
        <form class="w-full flex flex-col gap-10" method="post" action="{{ route('piggybanks.store') }}">
            @csrf
            <div class="form-group">
                <label for="account">Account</label>
                <select  id="account" name="account">
                    <option value="-1">-- Choose savings account --</option>
                    <option>Spaarrekening</option>
                </select>
            </div>
            <div class="form-group">
                <label for="goal_name">Goal name</label>
                <input type="text" id="goal_name" name="goal_name">
            </div>
            <div class="form-group">
                <label for="Balance">Balance</label>
                <input type="number" id="Balance" name="Balance" step=".01" >
            </div>
            <div class="form-group">
                <label for="savings">Goal amount</label>
                <input type="number" id="savings" name="savings" step=".01">
            </div>

            <button type="submit">Create piggybank</button>
        </form>
    </div>
</x-layout>

