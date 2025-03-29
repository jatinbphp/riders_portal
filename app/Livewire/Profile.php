<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Clubs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    use WithFileUploads;

    public $sport_type, $specialization, $height, $weight, $about, $club_id, $profile_picture, $status;
    public $clubs;
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    public function mount()
    {       
        $this->menu = "Profile";
        $this->breadcrumb = [['route' => 'profile', 'title' => 'Profile']];
        $this->activeMenu = 'Edit';

        $profile = Auth::user();

        if ($profile) {
            $this->sport_type = $profile->sport_type;
            $this->specialization = $profile->specialization;
            $this->height = $profile->height;
            $this->weight = $profile->weight;
            $this->about = $profile->about;
            $this->club_id = $profile->club_id;
        }

        $this->clubs = Clubs::all();
    }

    public function render()
    {
        return view('livewire.profile')->layout('layouts.app');
    }

    public function saveProfile()
    {
        $this->validate([
            'sport_type' => 'required|string',
            'specialization' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'about' => 'nullable|string',
            'club_id' => 'nullable|exists:clubs,id',
            'profile_picture' => 'nullable|image|max:1024', // 1MB max
        ]);

        $profile = Auth::user();
        $profile->update([
            'sport_type' => $this->sport_type,
            'specialization' => $this->specialization,
            'height' => $this->height,
            'weight' => $this->weight,
            'about' => $this->about,
            'club_id' => $this->club_id,
        ]);

        if ($this->profile_picture) {
            $path = $this->profile_picture->store('profile_pictures', 'public');
            $profile->update(['profile_picture' => $path]);
        }

        session()->flash('success', 'Profile updated successfully!');
    }
}
