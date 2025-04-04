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
                            <div class="col-auto">
                                <a href="{{ route('document-uploads.create') }}" class="btn btn-sm btn-info" wire:navigate>
                                    <i class="fa fa-plus pr-1"></i> Add New Document
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="route_name" value="{{ route('document-uploads.data') }}">
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
                                    <th width="5%">Action</th>
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
    function initializeDataTable() {
        let table = $('#documentUploads');

        // Destroy DataTable if it exists
        if ( $.fn.DataTable.isDataTable(table) ) {
            table.DataTable().destroy(); // Fully remove DataTable instance
            table.find('tbody').empty(); // Clear table body to avoid duplicates
        }

        // Reinitialize DataTable
        setTimeout(() => {
            table.DataTable({
                processing: true,
                serverSide: true,
                destroy: true, // Ensure clean reinitialization
                ajax: "{{ route('document-uploads.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'speed', name: 'speed' },
                    { data: 'strength', name: 'strength' },
                    { data: 'agility', name: 'agility' },
                    { data: 'endurance', name: 'endurance' },
                    { data: 'flexibility', name: 'flexibility' },
                    { data: 'document_path', name: 'document_path' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
        }, 500); // Slight delay to allow DOM updates
    }

    document.addEventListener("DOMContentLoaded", function () {
        initializeDataTable(); // Run on first load
    });

    Livewire.hook('message.processed', (message, component) => {
        initializeDataTable(); // Run after Livewire updates
    });

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
                Livewire.dispatch('deleteDocument', { documentId });
            }
        });
    });

    $(document).on('click', '.status-btn', function () {
        let documentId = $(this).data('id');
        Livewire.dispatch('updateStatus', { id: documentId });
    });

</script>
@endsection


