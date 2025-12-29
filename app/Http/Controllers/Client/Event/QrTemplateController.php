<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\PurchaseModel;
use App\Models\QrTemplateFilesModel;
use App\Models\QRTemplateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\QRTemplateFileModel;

class QrTemplateController extends Controller
{
    public function index(Request $request, FolderModel $folder)
    {
        $purchase = PurchaseModel::with('package')
            ->where('user_id', auth()->id())
            ->active()
            ->first();

        $plan = $purchase?->package?->plan; // beginner | basic | pro | premium
        $isPremium = in_array($plan, ['pro', 'premium']);

        $activeTemplate = $request->query('template');

        $templatesQuery = QRTemplateModel::where('is_active', true)
            ->with(['files' => function ($q) {
                $q->whereNull('deleted_at');
            }]);

        // 🔒 FILTER BERDASARKAN PAKET
        if (!$isPremium) {
            $templatesQuery->where('name_template', 'Standar');
        }

        $templates = $templatesQuery->get();

        // filter via tab klik
        if ($activeTemplate) {
            $templates = $templates->where('name_template', $activeTemplate);
        }

        return view('dashboard.client.event.qr_template.index', [
            'templates'       => $templates,
            'activeTemplate'  => $activeTemplate,
            'event'           => $folder,
            'isPremium'       => $isPremium,
        ]);
    }


    public function download(FolderModel $folder, $templateFile)
    {
        $link = $folder->link;

        if (!$link || !$link->generate_qr_code) {
            abort(404, 'QR Code belum tersedia');
        }

        $qrPath = public_path('qr/' . $link->generate_qr_code);
        $template = QrTemplateFilesModel::findOrFail($templateFile);
        $templatePath = storage_path('app/public/' . $template->path_template);

        if (!file_exists($qrPath) || !file_exists($templatePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $manager = new ImageManager(new Driver());

        $canvas = $manager->read($templatePath);


        $qr = $manager->read($qrPath)->resize(500, 500);

        $canvas->place($qr, 'center', 0, 0);

        $filename = 'TEMPLATE_' . $folder->public_code . '_' . time() . '.png';
        $tempPath = storage_path('app/public/temp/' . $filename);

        if (!is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $canvas->toPng()->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }



}
