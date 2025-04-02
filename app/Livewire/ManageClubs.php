<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Clubs;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ManageClubs extends Component
{
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    protected $listeners = ['deleteClub'];

    public function mount()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Allow only super_admins to view clubs
        if ($user && $user->role === 'super_admin') {
            $this->clubs = Clubs::all();
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function render()
    {
        $this->menu = "Club";
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];
        $this->activeMenu = 'Club';
        return view('livewire.manage-clubs')->extends('layouts.app');
    }

    public function getClubData()
    {
        return DataTables::of(Clubs::select())
            ->addColumn('actions', function ($row) {
                return view('livewire.manage-clubs.actions', ['club' => $row, 'type' => 'action']);
            })->addColumn('status', function ($row) {
                return view('livewire.manage-clubs.actions', ['club' => $row, 'type' => 'status']);
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function updateStatus($id)
    {
        if($id){
            $club = Clubs::findOrFail($id);
            $club->status = !$club->status;
            $club->save();
        }
    }

    public function deleteClub($clubId)
    {
        $club = Clubs::find($clubId);
        
        if ($club) {
            $club->delete();
            $this->dispatch('clubDeleted');
        }
    }
}
