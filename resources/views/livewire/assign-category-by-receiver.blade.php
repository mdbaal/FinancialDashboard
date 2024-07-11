<div class="assign-by-receiver">
    <div class="assign-by-receiver-select">
        <label>Account</label>
        <select wire:model="selectedAccount">
            @foreach( $accounts as $account)
                @if( $account->name === $selectedAccount)
                    <option selected value="{{ $account->name }}">{{ $account->name }}</option>
                @else
                    <option value="{{ $account->name }}">{{ $account->name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="assign-by-receiver-select">
        <label>Receiver</label>
        <select wire:model="selectedReceiver">
            @foreach( $receivers as $receiver)
                @if( $receiver === $selectedReceiver)
                    <option value="{{ $receiver }}" selected>{{ $receiver }}</option>
                @else
                    <option value="{{ $receiver }}">{{ $receiver }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="assign-by-receiver-select">
        <label>Category</label>
        <select wire:model="selectedCategory">
            @foreach( $categories as $category)
                @if( $category->name === $selectedCategory)
                    <option value="{{ $category->name }} selected>{{ $category->name }}</option>
                @else
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="assign-by-receiver-select justify-end">
        <button type="button" class="btn btn-edit" wire:click="assignMass">Assign</button>
    </div>
</div>
