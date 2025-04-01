<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use DataTables;

class ClubController extends Controller
{
    public function getClubs(Request $request)
    {
        if ($request->ajax()) {
            $clubs = Club::select(['id', 'name', 'description', 'status']);
            
            return DataTables::of($clubs)
                ->addColumn('status', function ($club) {
                    return $club->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($club) {
                    return '
                        <a href="' . route('clubs.edit', $club->id) . '" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="' . $club->id . '">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
}
