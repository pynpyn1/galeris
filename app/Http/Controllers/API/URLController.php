<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LinkModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class URLController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {

             $query = LinkModel::withTrashed()->with(['folder'])->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('url', function ($item) {

                    if (!$item->slug) return '-';

                    $redirectUrl = url('/url/' . $item->slug);

                    if ($item->deleted_at) {
                        return '<button class="btn btn-outline-primary btn-sm" disabled>URL Disabled</button>';
                    }

                    return '<a href="'.$redirectUrl.'" target="_blank" class="btn btn-outline-primary btn-sm">
                                View URL
                            </a>';
                })->addColumn('folder_name', function ($item) {
                    return $item->folder->name ?? '-';
                })->addColumn('qr', function ($item) {
                    if ($item->generate_qr_code) {

                            $qrPath = public_path('qr/' . $item->generate_qr_code);

                            if (!file_exists($qrPath)) {
                                return '<img src="' . asset('asset/img/404.jpeg') . '" width="50">';
                            }

                            return '<img src="' . asset('qr/' . $item->generate_qr_code) . '" width="50">';
                        }

                    return '<img src="' . asset('asset/img/404.jpeg') . '" width="50">';
                })->addColumn('status', function ($item) {
                    if ($item->deleted_at) {
                        return '<span class="badge bg-warning">Deleted</span>';
                    }
                    return '<span class="badge bg-success">Active</span>';
                })->addColumn('action', function ($item) {
                    if ($item->deleted_at) {
                        return '<button class="btn btn-danger btn-sm" disabled>Deleted</button>';
                    }

                    $deleteUrl = route('manage.url.destroy', $item->id);

                    return '
                        <form id="delete-form-'.$item->id.'" action="'.$deleteUrl.'" method="POST" class="d-inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="button" class="btn btn-danger btn-sm delete-url-btn" data-id="'.$item->id.'">
                                Delete
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['qr', 'status', 'action','url'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }


}
