<div class="content-wrapper" style="min-height: 946px;">
    @include('common.header', [
        'menu' => $menu,
        'breadcrumb' =>  $breadcrumb,
        'active' => $activeMenu
    ])
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{($clubId) ? 'Edit' : 'Add' }} {{$menu}}</h3>
                    </div>
                    <form wire:submit.prevent="updateClub">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name: <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Please Enter Club Name" wire:model="name" class="form-control">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description: <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Please Enter Club Description" wire:model="description" class="form-control">
                                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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
                                <a href="{{ route('clubs') }}" wire:navigate><button class="btn btn-default" type="button">Back</button></a>
                                <button type="submit" class="btn btn-primary">{{($clubId) ? 'Update' : 'Add' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
