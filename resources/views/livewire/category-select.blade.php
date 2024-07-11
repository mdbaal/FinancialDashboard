<select wire:model="selectedCategory" wire:change="setCategory">
    @foreach( $categories as $category)
        @if( $category->name === $transaction->category)
            <option selected>{{ $category->name }}</option>
        @else
            <option>{{ $category->name }}</option>
        @endif
    @endforeach
</select>
