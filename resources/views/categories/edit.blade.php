<x-layout>
    <x-slot:title>Edit category</x-slot:title>
    <h1 class="w-full text-3xl">Edit category</h1>

    <div class="drop-shadow border-gray-200 rounded edit-category justify-between gap-20">
        <form class="w-full" method="post" action="{{ route('categories.update',['category'=> $category]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Category</label>
                <input type="text" id="name" name="name" value="{{ $category->name }}">
            </div>

            <button type="submit">Edit category</button>
        </form>
    </div>
</x-layout>
