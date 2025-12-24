<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrTemplateFilesModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'qr_template_files';
    protected $guarded = [];

    public function template()
    {
        return $this->belongsTo(QRTemplateModel::class, 'qr_template_id');
    }
}
