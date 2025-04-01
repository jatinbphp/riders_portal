<?php

namespace App\Livewire\ManageClubs;

use Livewire\Component;
use App\Models\Clubs;


class ManageClubForm extends Component
{
    public $clubId;
    public $name, $description, $status;
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    public function render()
    {
        return view('livewire.manage-clubs.manage-club-form')->extends('layouts.app');
    }

    public function mount($id = null)
    {
        $this->menu = "Clubs";
        $this->breadcrumb = [
            ['route' => 'clubs', 'title' => 'Clubs'],
        ];
        $this->activeMenu = 'Add';
        $this->status = 1;
        if($id){
            $this->activeMenu = 'Edit';
            $club = Clubs::findOrFail($id);
            $this->clubId = $club->id;
            $this->name = $club->name;
            $this->description = $club->description;
            $this->status = $club->status;
        }
    }

    public function updateClub()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $filedData = [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => auth()->id(),
        ];

        if($this->clubId){
            $club = Clubs::findOrFail($this->clubId);
            $club->update($filedData);
            session()->flash('success', 'Club updated successfully!');
        } else {
            Clubs::create($filedData);
            session()->flash('success', 'Club created successfully!');
        }

        $this->redirect(route('clubs'), navigate: true);
    }
}
