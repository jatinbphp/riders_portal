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
                        <h3 class="card-title">Edit {{ $menu }}</h3>
                    </div>
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
                                        <label for="nationality">Nationality</label>
                                        <select id="nationality" wire:model="nationality" class="form-control">
                                            <option value="">-- Select Country --</option>
                                            @foreach (config('countries') as $code => $name)
                                                <option value="{{ $code }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" wire:model="dob" class="form-control">
                                        @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

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
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label></label>
                                        @php
                                            $doc = \App\Models\DocumentUpload::where('user_id', Auth::id())->first();
                                        @endphp
                                        @if ($doc && $doc->document_path)
                                            <a href="{{ asset($doc->document_path) }}" target="_blank" class="btn btn-lg btn-primary mt-4">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="biography">Biography</label>
                                        <textarea wire:model="biography" class="form-control" rows="4"></textarea>
                                        @error('biography') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div> 
                                @endif
 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="onoffswitch4" wire:ignore>
                                            <input type="checkbox" {{ ($status) ? 'checked' : '' }} name="onoffswitch4" class="onoffswitch4-checkbox" id="myonoffswitch4" wire:model="status">
                                            <label class="onoffswitch4-label" for="myonoffswitch4">
                                                <span class="onoffswitch4-inner"></span>
                                                <span class="onoffswitch4-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector("#nationality");

        if (input) {
            const iti = window.intlTelInput(input, {
                // Show just the country dropdown (we will ignore the phone part)
                initialCountry: "auto",
                separateDialCode: false,
                nationalMode: false,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                geoIpLookup: function (callback) {
                    fetch("https://ipapi.co/json")
                        .then(res => res.json())
                        .then(data => {
                            callback(data.country_code);
                        })
                        .catch(() => {
                            callback("US");
                        });
                }
            });

            // Optional: get country data when user selects country
            input.addEventListener("countrychange", function () {
                const countryData = iti.getSelectedCountryData();
                console.log("Selected country:", countryData.name, countryData.iso2);
                // You can send this to Livewire or any hidden field
            });
        }
    });
</script>



@endpush
