<div class="content-wrapper">
    @include('common.header', [
        'menu' => $menu,
        'breadcrumb' =>  $breadcrumb,
        'active' => $activeMenu
    ])
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Upload Performance Data</h3>
                    </div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="submit" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="speed">Speed</label>
                                <input type="number" id="speed" wire:model="speed" class="form-control" required>
                                @error('speed') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="strength">Strength</label>
                                <input type="number" id="strength" wire:model="strength" class="form-control" required>
                                @error('strength') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="agility">Agility</label>
                                <input type="number" id="agility" wire:model="agility" class="form-control" required>
                                @error('agility') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="endurance">Endurance</label>
                                <input type="number" id="endurance" wire:model="endurance" class="form-control" required>
                                @error('endurance') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="flexibility">Flexibility</label>
                                <input type="number" id="flexibility" wire:model="flexibility" class="form-control" required>
                                @error('flexibility') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="document">Upload Document</label>
                                <input type="file" id="document" wire:model="document" class="form-control" required>
                                @error('document') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
