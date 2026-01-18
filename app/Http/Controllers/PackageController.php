<?php

namespace App\Http\Controllers;

use App\Models\PackageModel;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return view('dashboard.package.read');
    }
    
    public function edit($id)
    {
        $package = PackageModel::findOrFail($id);
        return view('dashboard.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = PackageModel::findOrFail($id);

        $request->validate([
            'plan' => 'required|in:beginner,basic,pro,premium',
            'package_name' => 'required|string|max:255',
            'package_desc' => 'required',
            'price' => 'required',
            'features' => 'required|array|min:3',
            'features.*' => 'required|string|min:3',
            'is_active' => 'boolean',
        ]);

        $price = (int) preg_replace('/[^0-9]/', '', $request->price);

        $package->update([
            'plan' => $request->plan,
            'package_name' => $request->package_name,
            'package_desc' => $request->package_desc,
            'price' => $price,
            'storage_limit_gb' => $request->storage_limit_gb,
            'feature' => $request->features ?? [],
            'is_active' => $request->has('is_active')

        ]);

        return redirect()
            ->route('manage.package.index')
            ->with('success', 'Package berhasil diupdate.');
    }

}
