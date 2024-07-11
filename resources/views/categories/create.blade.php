<x-layout>
    <x-slot:title>Create category</x-slot:title>
    <h1 class="w-full text-3xl">Create category</h1>

    <div class="drop-shadow border-gray-200 rounded create-category justify-between gap-20">
        <form class="w-full" method="post" action="{{ route('categories.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Category</label>
                <input type="text" id="name" name="name">
            </div>

            <button type="submit">Create category</button>
        </form>
    </div>
</x-layout>
