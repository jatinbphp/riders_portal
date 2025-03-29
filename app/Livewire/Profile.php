<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public function render() {
        $this->user = Auth::user();
        return view('livewire.profile')->extends('layouts.app');
    }
}
