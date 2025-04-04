<div class="content-wrapper"> 
    @include('common.header', [
        'menu' => $menu,
        'breadcrumb' => $breadcrumb,
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
                                <a href="{{ route('athlete.create') }}" class="btn btn-sm btn-info" wire:navigate>
                                    <i class="fa fa-plus pr-1"></i> Add New Athlete
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="route_name" value="{{ route('athlete') }}">
                    <div class="card-body table-responsive" wire:ignore>
                        <table id="athleteTable" class="table table-bordered table-striped datatable-dynamic"> 
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">First Name</th>
                                    <th width="10%">Last Name</th>
                                    <th width="15%">Email</th>
                                    <!-- <th width="5%">Height</th>
                                    <th width="5%">Weight</th>
                                    <th width="10%">Sport Type</th>
                                    <th width="10%">Specialization</th> -->
                                    <th width="7%">Status</th>
                                    <th width="7%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> 
                        @livewire('athlete-view')
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
    <script>
        $(document).ready(function () {  
            function loadDataTable() {
                if ($.fn.DataTable.isDataTable('#athleteTable')) {
                    $('#athleteTable').DataTable().destroy();
                }

                $('#athleteTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('athlete.data') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'firstname', name: 'firstname' },
                        { data: 'lastname', name: 'lastname' },
                        { data: 'email', name: 'email' },
                      /*  { data: 'height', name: 'height' },
                        { data: 'weight', name: 'weight' },
                        { data: 'sport_type', name: 'sport_type' },
                        { data: 'specialization', name: 'specialization' },*/
                        { data: 'status', name: 'status'},
                        { data: 'actions', name: 'actions', orderable: false, searchable: false }
                    ]
                });
            }
 
            loadDataTable();
 
            $(document).on('click', '.delete-btn', function () {
                let athleteId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This athlete will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('athleteDeleted', { athleteId: athleteId }); // Use 'emit' instead of 'dispatch'
                    }
                });
            });

            Livewire.on('deleteAthlete', function () {
                loadDataTable(); // Ensure this function refreshes the table properly
            });

            $(document).on('change', '.status-toggle', function () {
                let athleteId = $(this).data('id');
                Livewire.dispatch('updateAthleteStatus', { id: athleteId });
            });

            Livewire.on('statusUpdated', function () {
                Swal.fire({
                    title: "Status Updated!",
                    text: "The athlete's status has been changed successfully.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                loadDataTable();
            });
        });
    </script>
@endsection
