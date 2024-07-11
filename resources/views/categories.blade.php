<x-layout>
    <x-slot:title>Categories</x-slot:title>
    <h1 class="w-full text-3xl">Categories</h1>

    <a class="bg-blue-400 text-white rounded drop-shadow my-5 block w-fit p-1" href="{{ route('categories.create') }}">Create
        category</a>

    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2 mt-5">
        <h2 class="text-3xl">Assign categories by receiver</h2>
        <livewire:assign-category-by-receiver></livewire:assign-category-by-receiver>
    </div>

    <div class="w-full drop-shadow-xl border-2 border-gray-200 rounded p-2 mt-5">
        <table class="w-full text-md text-left">
            <thead class="text-gray-700 uppercase bg-gray-50">
            <tr>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $categories as $category)
                <tr class="odd:bg-gray-300"><td class="w-full">{{ $category->name }}</td>
                <td class="text-center">
                    <a href="{{ route('categories.edit',[$category]) }}"><span
                            class="material-symbols-outlined btn btn-edit">edit</span>
                    </a>
                </td>
                <td class="text-center">
                    <form method="post"
                          action="{{ route('categories.destroy',[$category]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-delete-small"><span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-layout>
