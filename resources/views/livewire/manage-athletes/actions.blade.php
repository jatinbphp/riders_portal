@if(isset($type))
    @if($type == 'action')
        <div class="action-buttons">
            <a href="{{ route('athlete.edit', $athlete->id) }}" class="btn btn-info btn-sm" wire:navigate>
                <i class="fa fa-edit"></i>
            </a>
            <a class="btn btn-danger btn-sm delete-btn" data-id="{{ $athlete->id }}">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    @endif

    @if($type == 'status')
        <div class="onoffswitch4">
        <input type="checkbox" class="onoffswitch4-checkbox"
               id="myonoffswitch4-{{$athlete->id}}"
               name="onoffswitch4"
               wire:click="toggleStatus({{ $athlete->id }})"
               {{ $athlete->status ? 'checked' : '' }}>
               
        <label class="onoffswitch4-label" for="myonoffswitch4-{{$athlete->id}}">
            <span class="onoffswitch4-inner"></span>
            <span class="onoffswitch4-switch"></span>
        </label>
    </div>
    @endif
@endif
