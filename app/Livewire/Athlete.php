<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Athlete extends Component
{
    use WithPagination;

    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $firstname, $lastname, $email, $password, $confirmpassword, $status, $athlete_id;
    public $isEditMode = false;

    
    protected $listeners = ['athleteDeleted' => 'deleteAthlete'];

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|same:confirmpassword',
        'confirmpassword' => 'required|min:6',
    ];

    public function mount()
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $this->menu = "Athletes";
        $this->breadcrumb = [
            ['route' => route('dashboard'), 'title' => 'Dashboard'],
        ];
        $this->activeMenu = 'Athletes'; 
    }

    public function resetFields()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->password = '';
        $this->confirmpassword = '';
        $this->status = 1;
        $this->athlete_id = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => $this->status,
            'role' => 'athlete',
        ]);

        session()->flash('success', 'Athlete added successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $athlete = User::findOrFail($id);
        $this->athlete_id = $athlete->id;
        $this->firstname = $athlete->firstname;
        $this->lastname = $athlete->lastname;
        $this->email = $athlete->email;
        $this->status = $athlete->status;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->athlete_id,
        ]);

        $athlete = User::findOrFail($this->athlete_id);
        $athlete->update([
            'lastname' => $this->lastname,
            'email' => $this->email,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Athlete updated successfully.');
        $this->resetFields();
    }

    public function deleteAthlete($athleteId) // Expect a single ID, not an array
    {
        $athlete = User::find($athleteId);
        
        if ($athlete) {
            $athlete->delete();
            session()->flash('success', 'Athlete deleted successfully.');
        } else {
            session()->flash('error', 'Athlete not found.');
        }

        // Emit event to refresh table after deletion
        $this->dispatch('deleteAthlete');
    }

    public function toggleStatus($id)
    {
        $athlete = User::findOrFail($id);
        $athlete->status = !$athlete->status; // Toggle status using boolean
        $athlete->save();

        session()->flash('success', 'Status updated successfully.');

        // Refresh the component after updating status
        $this->dispatch('statusUpdated');
    }

    public function render()
    {
        $this->menu = "Athletes";
        
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];

        $this->activeMenu = 'Athletes';

        $athletes = User::where('role', 'athlete')->paginate(10);

        return view('livewire.athlete', compact('athletes'))->extends('layouts.app');
    } 
}
