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
                        <h3 class="card-title">{{($uplaodId) ? 'Edit' : 'Add' }} {{$menu}}</h3>
                    </div>
                    <form wire:submit.prevent="manageUploads">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title: <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Please Enter Title" wire:model="title" class="form-control">
                                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>File: <span class="text-danger">*</span></label><br>
                                        <input type="file" wire:model="file" id="file" class="form-control" accept="image/*,video/*">
                                        @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('clubs') }}" wire:navigate><button class="btn btn-default" type="button">Back</button></a>
                                <button type="submit" class="btn btn-primary">{{($uplaodId) ? 'Update' : 'Add' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
<script>
    document.addEventListener("livewire:navigated", function () {
        $('.select-data').each(function () {
            let $this = $(this);
            if ($this.next('.select2-container').length) {
                $this.next('.select2-container').remove();
                $this.removeClass('select2-hidden-accessible').removeAttr('data-select2-id');
            }

            $this.select2({
                placeholder: $this.data('placeholder') || 'Please select an option',
                allowClear: true
            });
        });

        $('.select-data').on('change', function (e) {
            let fieldName = $(this).attr('wire:model');
            @this.set(fieldName, $(this).val());
        });
    });
</script>
@endsection


