<?php

namespace App\Livewire\ManageClubs;

use Livewire\Component;

class ManageClubForm extends Component
{
    public function render()
    {
        return view('livewire.manage-clubs.manage-club-form')->extends('layouts.app');
    }
}
