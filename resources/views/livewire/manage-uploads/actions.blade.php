@if(isset($type))
    @if($type == 'action')
        @if(auth()->user()->role === 'athlete')
            <div class="action-buttons">
                <a class="btn btn-danger btn-sm delete-btn" data-id="{{ $uploads->id }}">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        @endif
    @endif
    @if($type == 'image')
        @if ($uploads->type == $typeImage)
            <img src="{{ asset($uploads->path) }}" alt="Uploaded Image" width="50" height="50">
        @else
            <video width="100" height="100" controls>
                <source src="{{ asset($uploads->path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif
    @endif
@endif