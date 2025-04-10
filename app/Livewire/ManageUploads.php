<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $isSuperAdmin = $user->role === 'super_admin';

        $query = Uploads::with('user');
        if (!$isSuperAdmin) {
            $query->where('user_id', $user->id);
        }

        $dataTable = DataTables::of($query);

         if ($isSuperAdmin) {
            $dataTable
                ->addColumn('user_id', function ($row) {
                    return $row->user->id ?? '-';
                })
                ->addColumn('firstname', function ($row) {
                    return $row->user->firstname ?? '-'; 
                })
                ->addColumn('lastname', function ($row) {
                    return $row->user->lastname ?? '-'; 
                });
        }

            $dataTable->addColumn('user_id', function ($row) {
                return $row->user->id ?? '-';
            })
            ->addColumn('firstname', function ($row) {
                return $row->user->firstname ?? '-'; 
            })
            ->addColumn('lastname', function ($row) {
                return $row->user->lastname ?? '-'; 
            })
            ->addColumn('image', function ($row) {
                return view('livewire.manage-uploads.actions', [
                    'uploads' => $row,
                    'type' => 'image',
                    'typeImage' => Uploads::TYPE_IMAGE,
                ]);
            });

        // Only add the 'actions' column if NOT super_admin
        if (!$isSuperAdmin) {
            $dataTable->addColumn('actions', function ($row) {
                return view('livewire.manage-uploads.actions', [
                    'uploads' => $row,
                    'type' => 'action',
                ]);
            });
        }

        return $dataTable
            ->rawColumns(['image', 'actions']) 
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
