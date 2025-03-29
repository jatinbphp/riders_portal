<?php

namespace App\Livewire;

use Livewire\Component;

class ManageClubs extends Component
{
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    protected $listeners = ['deleteBCompany'];

    public function render()
    {
        $this->menu = "Club";
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];
        $this->activeMenu = 'Club';
        return view('livewire.manage-clubs')->extends('layouts.app');
    }

    public function getBCompanysData()
    {
        return DataTables::of(BCompanyModel::select())
            ->addColumn('actions', function ($row) {
                return view('livewire.b-company.actions', ['company' => $row, 'type' => 'action']);
            })->addColumn('status', function ($row) {
                return view('livewire.b-company.actions', ['company' => $row, 'type' => 'status']);
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function updateStatus($id)
    {
        if($id){
            $company = BCompanyModel::findOrFail($id);
            $company->status = !$company->status;
            $company->save();
        }
    }

    public function deleteBCompany($companyId)
    {
        $company = BCompanyModel::find($companyId);
        
        if ($company) {
            $company->delete();
            $this->dispatch('bCompanyDeleted');
        }
    }
}
