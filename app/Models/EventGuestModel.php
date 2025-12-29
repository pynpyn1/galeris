<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGuestModel extends Model
{
    use HasFactory;
    protected $table = 'event_guest';
    protected $fillable = [
        'folder_id',
        'client_id',
        'name',
        'number',
        'sent',
        'sent_at'
    ];

    public function folder()
    {
        return $this->belongsTo(FolderModel::class, 'folder_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }
}
