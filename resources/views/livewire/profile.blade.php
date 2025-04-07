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
                        <h3 class="card-title">Edit {{$menu}}</h3>
                    </div>
                    <!-- <form wire:submit.prevent="updateProfile"> -->
                    <form wire:submit.prevent="updateProfile">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" placeholder="First Name" wire:model="firstname" class="form-control">
                                        @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" placeholder="Last Name" wire:model="lastname" class="form-control">
                                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" placeholder="Email" wire:model="email" class="form-control">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" placeholder="Enter Password" wire:model="password" class="form-control">
                                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" placeholder="Confirm Password" wire:model="password_confirmation" class="form-control">
                                        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @if(auth()->user()->role !== 'super_admin')
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Height (cm)</label>
                                        <input type="number" placeholder="Enter Height" wire:model="height" class="form-control">
                                        @error('height') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Weight (kg)</label>
                                        <input type="number" placeholder="Enter Weight" wire:model="weight" class="form-control">
                                        @error('weight') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sport Type</label>
                                        <input type="text" placeholder="Enter Sport Type" wire:model="sport_type" class="form-control">
                                        @error('sport_type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Club</label>
                                        <select name="club_id" class="form-control" wire:model.lazy="club_id" wire:change="updateClub">
                                            <option value="">Select Club</option>
                                            @foreach ($clubs as $club)
                                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Specialization</label>
                                        <input type="text" placeholder="Enter Specialization" wire:model="specialization" class="form-control">
                                        @error('specialization') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                  
                                @foreach (['speed', 'strength', 'agility', 'endurance', 'flexibility'] as $field)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="{{ $field }}">{{ ucfirst($field) }}</label>
                                            <input type="text" wire:model="{{ $field }}" class="form-control">
                                            @error($field) <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endforeach
            
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="document_path">Upload Document</label>
                                    <input type="file" wire:model="document_path" class="form-control">
                                    @error('document_path') <span class="text-danger">{{ $message }}</span> @enderror

                                    @php
                                        $doc = \App\Models\DocumentUpload::where('user_id', Auth::id())->first();
                                    @endphp
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label></label>
                                        
                                        @if ($doc && $doc->document_path) 

                                            <a href="{{ asset('storage/' . $doc->document_path) }}" target="_blank" class="btn btn-lg btn-primary mt-4">
                                                <i class="fa fa-download"></i>  Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="onoffswitch4" wire:ignore>
                                            <input type="checkbox" {{($status) ? 'checked' : ''}} name="onoffswitch4" class="onoffswitch4-checkbox" id="myonoffswitch4" wire:model="status">
                                            <label class="onoffswitch4-label" for="myonoffswitch4">
                                                <span class="onoffswitch4-inner"></span>
                                                <span class="onoffswitch4-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>         </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

