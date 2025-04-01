<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentUpload;
use Illuminate\Support\Facades\Auth;

class DocumentUploads extends Component
{
    use WithFileUploads;

    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $speed = 0;
    public $strength = 0;
    public $agility = 0;
    public $endurance = 0;
    public $flexibility = 0;
    public $document;
    public $existingStats;

    public function mount()
    {
        // Load existing stats for authenticated user (if applicable)
        $this->existingStats = DocumentUpload::where('user_id', Auth::id())->first();

        if ($this->existingStats) {
            $this->speed = $this->existingStats->speed;
            $this->strength = $this->existingStats->strength;
            $this->agility = $this->existingStats->agility;
            $this->endurance = $this->existingStats->endurance;
            $this->flexibility = $this->existingStats->flexibility;
        }
    }

    public function submit()
    {
        $this->validate([
            'speed' => 'required|integer|min:0|max:100',
            'strength' => 'required|integer|min:0|max:100',
            'agility' => 'required|integer|min:0|max:100',
            'endurance' => 'required|integer|min:0|max:100',
            'flexibility' => 'required|integer|min:0|max:100',
        ]);

        DocumentUpload::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'speed' => $this->speed,
                'strength' => $this->strength,
                'agility' => $this->agility,
                'endurance' => $this->endurance,
                'flexibility' => $this->flexibility,
            ]
        );

        session()->flash('message', 'Profile stats saved successfully!');
    }

    public function uploadDocument()
    {
        $this->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $this->document->store('documents');

        DocumentUpload::updateOrCreate(
            ['user_id' => Auth::id()],
            ['document_path' => $path]
        );

        session()->flash('document_message', 'Document uploaded successfully!');
    } 

    public function render()
    {
        $this->menu = "Documents Uploads";
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];
        $this->activeMenu = '   Uploads';
        return view('livewire.document-uploads')->extends('layouts.app');
    }

}
