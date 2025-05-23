<header class="bg-blue-300 drop-shadow-md h-20">
    <div class="max-w-screen-xl mx-auto flex flex-row py-5 gap-2 justify-between">
        <img class="rounded drop-shadow logo" src="{{url('images/logo.jpg')}}" alt="logo">
        <a href="{{ route('home') }}" class="header-btn bg-blue-400 text-white p-2 rounded drop-shadow">Dashboard</a>
        <a href="{{ route('accounts.index') }}" class="header-btn bg-blue-400 text-white p-2 rounded drop-shadow">Accounts</a>
        <a href="{{ route("categories.index") }}" class="header-btn bg-blue-400 text-white p-2 rounded drop-shadow">Categories</a>
        <a href="{{ route('piggybanks.index') }}" class="header-btn bg-blue-400 text-white p-2 rounded drop-shadow">Piggybanks</a>
        <a href="{{ route('import') }}" class="header-btn bg-blue-400 text-white p-2 rounded drop-shadow">Import Account</a>
    </div>
</header>
