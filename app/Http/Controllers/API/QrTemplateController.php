<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QRTemplateModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QrTemplateController extends Controller
{
    public function data(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $query = QRTemplateModel::all();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('qr_files', function ($template) {

                if ($template->files->isEmpty()) {
                    return "<span class='text-muted'>Tidak ada file</span>";
                }

                $allFiles = [];
                foreach ($template->files as $file) {
                    $allFiles[] = asset('qr/' . $file->file_path);
                }

                $fileJson = htmlspecialchars(json_encode($allFiles), ENT_QUOTES, 'UTF-8');

                $html = "
                    <div class='qr-stack'
                        data-files=\"{$fileJson}\"
                        style='position:relative; width:140px; height:60px; cursor:pointer;'>
                ";

                $index = 0;
                foreach ($template->files as $file) {
                    $offset = $index * 14;
                    $url = asset('storage/' . $file->path_template);

                    $html .= "
                        <img src='{$url}'
                            style='
                                position:absolute;
                                left:{$offset}px;
                                top:0;
                                width:55px;
                                height:55px;
                                background:#fff;
                                padding:4px;
                                border-radius:8px;
                                border:1px solid #ddd;
                                box-shadow:0 3px 6px rgba(0,0,0,.2);
                            '>
                    ";
                    $index++;
                }


                $html .= "</div>";

                return $html;
            })
            ->addColumn('status', function ($template) {

                if ($template->deleted_at) {
                    return '<span class="badge bg-warning">Deleted</span>';
                }

                return $template->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('action', function ($template) {

                $editUrl   = route('manage.qr_template.edit', $template->id);
                $deleteUrl = route('manage.qr_template.destroy', $template->id);

                if ($template->deleted_at) {
                    return '
                        <button class="btn btn-danger btn-sm" disabled>
                            Deleted
                        </button>
                    ';
                }

                return '
                    <a href="'.$editUrl.'" class="btn btn-info btn-sm me-2">Manage</a>

                    <form action="'.$deleteUrl.'"
                          method="POST"
                          class="d-inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit"
                            class="btn btn-danger btn-sm delete-qr-template-btn">
                            Delete
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['qr_files', 'status', 'action'])
            ->make(true);
    }
}

