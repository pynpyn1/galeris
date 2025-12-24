<?php

namespace App\Http\Controllers;

use App\Models\QrTemplateFilesModel;
use App\Models\QRTemplateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QrTemplateController extends Controller
{

    public function index()
    {
        $templates = QRTemplateModel::latest()->get();

        return view('dashboard.qr_template.read', compact('templates'));
    }

    public function create()
    {
        return view('dashboard.qr_template.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_template' => 'required|string|max:255',
            'is_active'     => 'required|boolean',
            'files'         => 'required',
            'files.*'       => 'file|mimes:png,jpg,jpeg,svg|max:5120',
        ]);

        DB::transaction(function () use ($request) {

            $template = QRTemplateModel::create([
                'name_template' => $request->name_template,
                'is_active'     => $request->is_active,
            ]);

            foreach ($request->file('files') as $file) {

                $filename = uniqid('qr_') . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs(
                    'qr_templates/' . $template->id,
                    $filename,
                    'public'
                );

                QrTemplateFilesModel::create([
                    'qr_template_id' => $template->id,
                    'path_template'  => $path, // ✅ FIX
                    'file_type'      => $file->getClientOriginalExtension(),
                ]);
            }
        });

        return response()->json(['status' => 'success']);
    }





    public function edit($id)
    {
        $template = QRTemplateModel::findOrFail($id);

        return view('dashboard.qr_template.edit', [
            'template' => $template,
            'files'    => $template->files
        ]);
    }


    public function update(Request $request, $id)
    {
        $template = QRTemplateModel::findOrFail($id);

        $request->validate([
            'name_template' => 'required|string|max:255',
            'is_active'     => 'required|boolean',
            'templates'     => 'nullable|array',
            'templates.*'   => 'file|mimes:png,jpg,jpeg,svg|max:5120',
        ]);

        DB::transaction(function () use ($request, $template) {

            $template->update([
                'name_template' => $request->name_template,
                'is_active'     => $request->is_active,
            ]);

            if ($request->hasFile('templates')) {

                foreach ($request->file('templates') as $file) {

                    $filename = uniqid('qr_') . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs(
                        "qr_templates/{$template->id}",
                        $filename,
                        'public'
                    );

                    QrTemplateFilesModel::create([
                        'qr_template_id' => $template->id,
                        'path_template'  => $path,
                        'file_type'      => $file->getClientOriginalExtension(),
                    ]);
                }
            }
        });

        return redirect()
            ->route('manage.qr_template.index')
            ->with('success', 'QR Template berhasil diperbarui');
    }



    public function destroy($id)
    {
        $template = QRTemplateModel::with('files')->findOrFail($id);

        DB::transaction(function () use ($template) {

            foreach ($template->files as $file) {
                Storage::disk('public')->delete($file->path_template);
                $file->delete();
            }

            $template->delete();
        });

        return redirect()
            ->route('manage.qr_template.index')
            ->with('success', 'QR Template berhasil dihapus');
    }

    public function destroyFile($id)
    {
        $file = QrTemplateFilesModel::findOrFail($id);

        Storage::disk('public')->delete($file->path_template);
        $file->delete();

        return back()->with('success', 'File QR Template berhasil dihapus');
    }


}
