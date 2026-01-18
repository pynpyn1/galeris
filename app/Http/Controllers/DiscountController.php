<?php

namespace App\Http\Controllers;

use App\Models\DiscountCodeModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    public function index()
    {
        return view('dashboard.discount.read');
    }

    public function data()
    {
        $data = DiscountCodeModel::latest();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('type', fn ($row) => ucfirst($row->type))
            ->editColumn('value', function ($row) {
                if ($row->type == 'percent') {
                    return $row->value . '%';
                }
                return 'Rp ' . number_format($row->value, 0, ',', '.');
            })
            ->editColumn('is_active', function ($row) {
                $class = $row->is_active ? 'bg-light-success text-success' : 'bg-light-danger text-danger';
                $text = $row->is_active ? 'Active' : 'Inactive';
                return '<span class="badge ' . $class . '">' . $text . '</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex gap-2">
                        <a href="' . route('manage.discount.edit', $row->id) . '" class="btn btn-sm btn-icon btn-info">
                            Edit
                        </a>
                        <button class="btn btn-sm btn-icon btn-danger" onclick="deleteData('.$row->id.')">
                            Delete
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['action', 'is_active'])
            ->make(true);
    }

    public function create()
    {
        return view('dashboard.discount.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'      => 'required|string|max:50|unique:discount_code,code',
            'type'      => ['required', Rule::in(['fixed', 'percent'])],
            'value'     => 'required|integer|min:1',
            'start_at'  => 'nullable|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'quota'     => 'nullable|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        DiscountCodeModel::create([
            'code'      => strtoupper($request->code),
            'type'      => $request->type,
            'value'     => $request->value,
            'start_at'  => $request->start_at,
            'end_at'    => $request->end_at,
            'quota'     => $request->quota,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('manage.discount.index')
            ->with('success', 'Discount code berhasil dibuat');
    }

    public function edit(DiscountCodeModel $discount)
    {
        return view('dashboard.discount.edit', compact('discount'));
    }

    public function update(Request $request, DiscountCodeModel $discount)
    {
        $request->validate([
            'code'      => [
                'required', 'string', 'max:50',
                Rule::unique('discount_code', 'code')->ignore($discount->id)
            ],
            'type'      => ['required', Rule::in(['fixed', 'percent'])],
            'value'     => 'required|integer|min:1',
            'start_at'  => 'nullable|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'quota'     => 'nullable|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $discount->update([
            'code'      => strtoupper($request->code),
            'type'      => $request->type,
            'value'     => $request->value,
            'start_at'  => $request->start_at,
            'end_at'    => $request->end_at,
            'quota'     => $request->quota,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('manage.discount.index')
            ->with('success', 'Discount code berhasil diperbarui');
    }

    public function destroy(DiscountCodeModel $discount)
    {
        $discount->delete();

        return response()->json([
            'status' => true,
            'message' => 'Discount code berhasil dihapus'
        ]);
    }
    
}
