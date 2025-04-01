<?php
namespace App\Livewire\DocumentUploads;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentUpload; // Make sure you have this model

class DocumentUploadsForm extends Component
{
    use WithFileUploads;

    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $speed;
    public $strength;
    public $agility;
    public $endurance;
    public $flexibility;
    public $document;

    // Validation rules
    protected $rules = [
        'speed' => 'required|numeric|min:1|max:100',
        'strength' => 'required|numeric|min:1|max:100',
        'agility' => 'required|numeric|min:1|max:100',
        'endurance' => 'required|numeric|min:1|max:100',
        'flexibility' => 'required|numeric|min:1|max:100',
        'document' => 'required|file|mimes:pdf,doc,docx,pptx,xlsx|max:10240', // 10MB max size
    ]; 

    // Submit the form
    public function submit()
    {
        // Validate the data
        $this->validate();

        // Store the document
        $documentPath = $this->document->store('documents', 'public');

        // Save the form data to the database
        DocumentUpload::create([
            'speed' => $this->speed,
            'strength' => $this->strength,
            'agility' => $this->agility,
            'endurance' => $this->endurance,
            'flexibility' => $this->flexibility,
            'document_path' => $documentPath,
        ]);

        // Optionally flash a success message
        session()->flash('message', 'Document uploaded successfully!');

        // Reset the form fields
        $this->reset(['speed', 'strength', 'agility', 'endurance', 'flexibility', 'document']);
    }

    // Render the component view
    public function render()
    {
        return view('livewire.document-uploads.document-uploads-form')->extends('layouts.app');
    }
}
