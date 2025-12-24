<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QRTemplateModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'qr_template';
    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(QrTemplateFilesModel::class, 'qr_template_id');
    }
}
