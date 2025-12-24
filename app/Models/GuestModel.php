<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestModel extends Model
{
    use HasFactory;
    protected $table = 'event_guest';
    protected $fillable = [
        'folder_id',
        'client_id',
        'number',
        'sent',
        'sent_at'
    ];
}
