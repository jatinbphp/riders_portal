<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public function render() {
        return view('livewire.profile', ['user' => Auth::user()])->layout('layouts.app');
    }
}
