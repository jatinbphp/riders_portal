<div class="content-wrapper" style="min-height: 946px;">
    @include('common.header', [
        'menu' => $menu ?? 'Athletes',
        'breadcrumb' => $breadcrumb ?? [],
        'active' => $activeMenu ?? 'Athletes'
    ])

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ $athleteId ? 'Edit' : 'Add' }} Athlete</h3>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name: <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter Athlete Name" wire:model="name" class="form-control">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email: <span class="text-danger">*</span></label>
                                        <input type="email" placeholder="Enter Athlete Email" wire:model="email" class="form-control">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status: <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('athlete.index') }}" wire:navigate>
                                    <button class="btn btn-default" type="button">Back</button>
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ $athleteId ? 'Update' : 'Add' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
