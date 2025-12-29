<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\LinkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Support\Facades\Response;
use App\Imports\EventGuestImport;
use App\Models\PurchaseModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class ShareController extends Controller
{
    public function index(FolderModel $folder)
    {
        $link = $folder->link()->first();

        $url = url("/url/" . $link->slug);

        $purchase = PurchaseModel::with('package')
        ->where('user_id', auth()->id())
        ->active()
        ->first();


        $qr_path = asset('qr/' . $link->generate_qr_code);

        $isPro = in_array($purchase?->package?->plan, ['basic' ,'pro', 'premium']);

        return view('dashboard.client.event.share.index', [
            'event' => $folder,
            'url'   => $url,
            'link'  => $link,
            'qr_path' => $qr_path,
            'isPro' => $isPro
        ]);
    }

    public function generateqr(FolderModel $folder, Request $request)
    {
        $link = $folder->link()->first();

        $svg = $request->file('qr_svg');

        $filename = 'qr_' . $link->id . '_' . time() . '.svg';
        $path = public_path('qr/' . $filename);

        if (!file_exists(public_path('qr'))) {
            mkdir(public_path('qr'), 0755, true);
        }

        file_put_contents($path, file_get_contents($svg));

        $link->update([
            'generate_qr_code' => $filename
        ]);

        return response()->json([
            'success' => true,
            'qr_url' => asset('qr/' . $filename),
            'message' => 'Berhasil mengupdate qr'
        ]);
    }


    public function remind(FolderModel $folder, Request $request)
    {
        $request->validate([
            'send_wa' => 'required|boolean'
        ]);

        $link = $folder->link()->firstOrFail();

        $link->update([
            'send_wa' => $request->send_wa
        ]);

        return response()->json([
            'success' => true,
            'send_wa' => $link->send_wa,
            'message' => 'Berhasil mengupdate'
        ]);
    }


    public function downloadTemplate(FolderModel $folder)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['NAME', 'NUMBER'];
        $sheet->fromArray($headers, null, 'A1');

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '435ebf'],
            ],
        ];

        $sheet->getStyle('A1:B1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->getColumnDimension('A')->setWidth(55);
        $sheet->getColumnDimension('B')->setWidth(25);

        $sheet->getStyle('A2:B2')->getFont()->setItalic(true);
        $sheet->getStyle('A2:B2')->getFont()->getColor()->setARGB('435ebf');
        $sheet->getStyle('A2:B2')->getAlignment()->setWrapText(true);

        $sheet->setCellValue('A3', 'Budi Santoso');
        $sheet->setCellValueExplicit('B3', '89512345678', DataType::TYPE_STRING);

        $sheet->setCellValue('A4', 'Siti Aminah');
        $sheet->setCellValueExplicit('B4', '89598765432', DataType::TYPE_STRING);

        $sheet->getStyle('A1:B4')->getBorders();

        $writer = new Xlsx($spreadsheet);
        $filename = 'guest_template.xlsx';

        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return Response::make($excelOutput, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }



    public function import(FolderModel $folder, Request $request)
    {
        $purchase = PurchaseModel::with('package')
            ->where('user_id', auth()->id())
            ->active()
            ->first();

        $plan = $purchase?->package?->plan;

        if (!in_array($plan, ['basic', 'pro', 'premium'])) {
            abort(403, 'Fitur import Excel hanya tersedia untuk paket Basic sampai Premium.');
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $client_id = auth()->id();

        try {
            Excel::import(
                new EventGuestImport($folder->id, $client_id),
                $request->file('excel_file')
            );

            return redirect()->back()->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }






}
