<div class="assign-by-receiver">
    <div class="assign-by-receiver-select">
        <label>Account</label>
        <select wire:model="selectedAccount" wire:change="refreshReceivers">
            @foreach( $accounts as $account)
                @if( $account->name === $selectedAccount)
                    <option selected value="{{ $account->name }}">{{ $account->name }}</option>
                @else
                    <option value="{{ $account->name }}">{{ $account->name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <livewire:searchable-select wire:model="selectedReceivers" :options="$receivers"></livewire:searchable-select>

    <div class="assign-by-receiver-select">
        <label>Category</label>
        <input list="categories" wire:model="selectedCategory" type="text">
        <datalist id="categories">
            @foreach( $categories as $category)
                <option value="{{ $category->name }}"></option>
            @endforeach
        </datalist>
    </div>

    <div class="assign-by-receiver-select justify-center">
        <button type="button" class="btn btn-edit" wire:click="assignMass">Assign</button>
    </div>
</div>
