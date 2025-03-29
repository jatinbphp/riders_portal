<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Uploads;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ManageUploads extends Component
{
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    protected $listeners = ['deleteUploads'];

    public function render()
    {
        $this->menu = "Uploads";
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];
        $this->activeMenu = 'Uploads';
        return view('livewire.manage-uploads')->extends('layouts.app');
    }

    public function getUploadsData()
    {
        return DataTables::of(Uploads::select())
            ->addColumn('image', function ($row) {
                return view('livewire.manage-uploads.actions', ['uploads' => $row, 'type' => 'image', 'typeImage' => Uploads::TYPE_IMAGE]);
            })
            ->addColumn('actions', function ($row) {
                return view('livewire.manage-uploads.actions', ['uploads' => $row, 'type' => 'action']);
            })
            ->rawColumns(['actions', 'image'])
            ->make(true);
    }

    public function deleteUploads($uploadId)
    {
        $uploads = Uploads::find($uploadId);
        
        if ($uploads) {
            if (Storage::disk('public')->exists($uploads->path)) {
                Storage::disk('public')->delete($uploads->path);
            }
            $uploads->delete();
            $this->dispatch('uploadDeleted');
        }
    }
}
