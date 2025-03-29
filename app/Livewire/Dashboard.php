<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $totalCompanyCounts = [];
    
    public function render()
    {
        return view('livewire.dashboard')->extends('layouts.app');
    }
}
