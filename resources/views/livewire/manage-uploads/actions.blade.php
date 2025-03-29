@if(isset($type))
    @if($type == 'action')
        <div class="action-buttons">
            <a class="btn btn-danger btn-sm delete-btn" data-id="{{ $uploads->id }}">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    @endif
    @if($type == 'image')
        @if ($uploads->type == $typeImage)
            <img src="{{ asset('storage/' . $uploads->path) }}" alt="Uploaded Image" width="50" height="50">
        @else
            <video width="100" height="100" controls>
                <source src="{{ asset('storage/' . $uploads->path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif
    @endif
@endif