@if(isset($type) && $type === 'action')
   <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $document->id }}">
        <i class="fa fa-trash"></i> Delete
    </button> 
@endif 