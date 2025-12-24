<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChatBotModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChatBotController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = ChatBotModel::with('user')->withTrashed();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user', fn($row) => optional($row->user)->name ?? '-')
                ->addColumn('message', fn($row) => $row->message ?? '-')
                ->addColumn('status', fn($row) => $row->deleted_at
                    ? '<span class="badge bg-warning">Deleted</span>'
                    : '<span class="badge bg-success">Active</span>')
                ->addColumn('action', function ($row) {
                    $editUrl = route('manage.chatbot.edit', $row->id);
                    $deleteUrl = route('manage.chatbot.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-info btn-sm me-1">Edit</a>';

                    $deleteButton = '<form action="' . $deleteUrl . '" method="POST" class="d-inline" id="delete-form-' . $row->id . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="button" class="btn btn-danger btn-sm delete-chatbot-btn" data-id="' . $row->id . '">Delete</button>
                    </form>';

                    return $editButton . $deleteButton;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid Request'], 400);
    }




}
