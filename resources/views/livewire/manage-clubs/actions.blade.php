@if(isset($type))
    @if($type == 'action')
        <div class="action-buttons">
            <a href="{{route('clubs.edit', $club->id)}}" class="btn btn-info btn-sm" wire:navigate>
                <i class="fa fa-edit"></i>
            </a>
            <a class="btn btn-danger btn-sm delete-btn" data-id="{{ $club->id }}">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    @endif
    @if($type == 'status')
        <div class="onoffswitch4" wire:ignore>
            <input type="checkbox" class="onoffswitch4-checkbox"
                   id="myonoffswitch4-{{$club->id}}"
                   name="onoffswitch4"
                   wire:model="status"
                   wire:change="updateStatus({{ $club->id }})"
                   {{ $club->status ? 'checked' : '' }}>
                   
            <label class="onoffswitch4-label" for="myonoffswitch4-{{$club->id}}">
                <span class="onoffswitch4-inner"></span>
                <span class="onoffswitch4-switch"></span>
            </label>
        </div>
    @endif
@endif