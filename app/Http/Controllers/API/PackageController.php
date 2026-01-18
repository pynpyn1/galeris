<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PackageModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = PackageModel::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function ($package) {
                    $class = $package->is_active ? 'bg-light-success' : 'bg-danger';
                    $text  = $package->is_active ? 'Active' : 'Inactive';
                    return "<span class='badge {$class}'>{$text}</span>";
                })
                ->addColumn('price', function ($package) {
                    return 'Rp ' . number_format($package->price, 0, ',', '.');
                })
                ->addColumn('action', function ($package) {
                    $editUrl   = route('manage.package.edit', $package->id);

                    return '
                        <a href="'.$editUrl.'" class="btn btn-info btn-sm me-2">Edit</a>
                    ';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }
}
