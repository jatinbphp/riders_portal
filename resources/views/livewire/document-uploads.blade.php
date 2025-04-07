<div class="content-wrapper"> 
    @include('common.header', [
        'menu' => $menu,
        'breadcrumb' =>  $breadcrumb,
        'active' => $activeMenu
    ])
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <div class="row w-100 align-items-center">
                            <div class="col">
                                <span class="h6 mb-0">Manage {{$menu}}</span>
                            </div>
                            @if(auth()->user()->role === 'athlete')
                            <div class="col-auto">
                                <a href="{{ route('document-uploads.create') }}" class="btn btn-sm btn-info" wire:navigate>
                                    <i class="fa fa-plus pr-1"></i> Add New Document
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" id="route_name" value="{{ route('document-uploads.data') }}"> 
                    <input type="hidden" id="user_role" value="{{ auth()->user()->role }}">
                    <div class="card-body table-responsive" wire:ignore>
                        <table id="documentUploads" class="table table-bordered table-striped datatable-dynamic"> 
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="5%">Speed</th>
                                    <th width="5%">Strength</th>
                                    <th width="5%">Agility</th>
                                    <th width="5%">Endurance</th>
                                    <th width="5%">Flexibility</th>
                                    <th width="5%">Document</th> 
                                    @if(auth()->user()->role === 'athlete')
                                    <th width="5%">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
<script>
$(document).ready(function () {

    $(document).on('click', '.delete-btn', function () {
        let documentId = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This document will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteDocument', { documentId: documentId });
            }
        });
    });
 
    Livewire.on('documentDeleted', function () {
        $('#documentUploads').DataTable().ajax.reload(null, false);

        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Document has been deleted.',
            timer: 2000,
            showConfirmButton: false
        });
    });

});


</script>
@endsection


