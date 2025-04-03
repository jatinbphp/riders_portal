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
                                <a href="{{route('social-links.create')}}" class="btn btn-sm btn-info" wire:navigate>
                                    <i class="fa fa-plus pr-1"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="route_name" value="{{ route('social-links.data') }}">
                    <div class="card-body table-responsive" wire:ignore>
                        <table id="socialLinks" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="17%">Facebook</th>
                                    <th width="17%">Twitter</th>
                                    <th width="17%">Instagram</th>
                                    <th width="17%">Linkedin</th>
                                    <th width="17%">Status</th>
                                    <th width="40%">Action</th>
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
                let socialLinkId = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteSocialLink', { socialLinkId: socialLinkId });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: "Cancelled",
                            text: "Your social link is safe!",
                            icon: "info",
                            confirmButtonColor: "#3085d6"
                        });
                    }
                });
            });

            // Refresh DataTable when a social link is deleted
            Livewire.on('socialLinkDeleted', function () {
                $('#socialLinks').DataTable().ajax.reload(null, false);
            });
        });
    </script>
@endsection
