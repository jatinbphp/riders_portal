<div class="content-wrapper" style="min-height: 946px;">
    @include('common.header', [
        'menu' => $menu ?? 'Athlete',
        'breadcrumb' => $breadcrumb ?? [],
        'active' => $activeMenu ?? 'Athlete'
    ])

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ $athleteId ? 'Edit' : 'Add' }}</h3>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name: <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter First Name" wire:model="firstname" class="form-control">
                                        @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name: <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter Last Name" wire:model="lastname" class="form-control">
                                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
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
                                        <label>Password: {{ !$athleteId ? '*' : '' }}</label>
                                        <input type="password" placeholder="Enter Password" wire:model="password" class="form-control">
                                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password: {{ !$athleteId ? '*' : '' }}</label>
                                        <input type="password" placeholder="Confirm Password" wire:model="password_confirmation" class="form-control">
                                        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status: <span class="text-danger">*</span></label>
                                        <div class="onoffswitch4" wire:ignore>
                                            <input type="checkbox" {{($status) ? 'checked' : ''}} name="onoffswitch4" class="onoffswitch4-checkbox" id="myonoffswitch4" wire:model="status">
                                            <label class="onoffswitch4-label" for="myonoffswitch4">
                                                <span class="onoffswitch4-inner"></span>
                                                <span class="onoffswitch4-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('athlete') }}">
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
