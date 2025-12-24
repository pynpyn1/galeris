<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\VideoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    /**
     * Helper function untuk format byte ke format yang dapat dibaca (KB, MB, GB).
     */
    protected function formatBytes($bytes, $precision = 1) {
        if ($bytes === 0) return '0 B';
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

   public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = FolderModel::with(['videos' => function($q) {

                $q->withTrashed();
            }])
            ->withCount('videos')
            ->withSum('videos', 'size');
            $query = $query->select('folder.*');

            return DataTables::of($query)->addIndexColumn()
                ->addColumn('folder_name', function ($folder) {
                    return $folder->name;
                })
                ->addColumn('size', function ($folder) {
                $totalSizeBytes = $folder->videos()->sum('size');

                return $this->formatBytes($totalSizeBytes);
                })
                ->addColumn('status', function ($folder) {
                    $deleted = $folder->videos->whereNotNull('deleted_at')->count();
                    $active = $folder->videos->whereNull('deleted_at')->count();

                    if ($active > 0 && $deleted > 0) {
                        return '<span class="badge bg-warning">Mixed</span>';
                    }

                    if ($active > 0) {
                        return '<span class="badge bg-success">Active</span>';
                    }

                    if ($deleted > 0) {
                        return '<span class="badge bg-danger">Deleted</span>';
                    }

                    return '<span class="badge bg-secondary">Empty</span>';
                })
                ->addColumn('action', function ($folder) {
                    $editUrl = route('manage.video.edit', $folder->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm">
                            Kelola Video
                        </a>
                    ';
                })
                ->rawColumns(['size', 'status', 'action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }
}
