@if(isset($type) && $type === 'action')
   @if(auth()->user()->role === 'athlete')
      <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $document->id }}">
           <i class="fa fa-trash"></i>
      </button> 
   @endif 
@endif 