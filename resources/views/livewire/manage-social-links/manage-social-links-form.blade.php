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
                        <h3 class="card-title">{{($linkId) ? 'Edit' : 'Add' }} {{$menu}}</h3>
                    </div>
                    <form wire:submit.prevent="updateLinks">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook:</label>
                                        <input type="url" wire:model="facebook" class="form-control" placeholder="Enter Facebook URL">
                                        @error('facebook') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Twitter:</label>
                                        <input type="url" wire:model="twitter" class="form-control" placeholder="Enter Twitter URL">
                                        @error('twitter') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Instagram:</label>
                                        <input type="url" wire:model="instagram" class="form-control" placeholder="Enter Instagram URL">
                                        @error('instagram') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>LinkedIn:</label>
                                        <input type="url" wire:model="linkedin" class="form-control" placeholder="Enter LinkedIn URL">
                                        @error('linkedin') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status:</label>
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
                                <a href="{{ route('social-links') }}" wire:navigate><button class="btn btn-default" type="button">Back</button></a>
                                <button type="submit" class="btn btn-primary">{{($linkId) ? 'Update' : 'Add' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
