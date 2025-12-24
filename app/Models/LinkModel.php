<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class LinkModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'link';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $folderName = $model->folder->name ?? 'folder';

                $baseSlug = Str::slug($folderName);
                $random = Str::random(6);

                $model->slug = strtolower($baseSlug . '-' . $random);
            }
        });

        static::created(function ($model) {
            $fullUrl = url('/url/' . $model->slug);

            $qrPng = QrCode::format('png')
                ->size(300)
                ->style('dot')
                ->eye('square')
                ->color(40, 50, 80)
                ->generate($fullUrl);

            $filename = 'qr_' . $model->id . '_' . time() . '.png';
            $path = public_path('qr/' . $filename);
            file_put_contents($path, $qrPng);

            $model->generate_qr_code = $filename;
            $model->save();
        });

        static::restoring(function ($model) {
            if ($model->generate_qr_code) {
                $oldFile = public_path('qr/' . $model->generate_qr_code);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $fullUrl = url('/url/' . $model->slug);

            $qrPng = QrCode::format('png')
                ->size(300)
                ->style('dot')
                ->eye('square')
                ->color(40, 50, 80)
                ->generate($fullUrl);

            $filename = 'qr_' . $model->id . '_' . time() . '.png';
            $path = public_path('qr/' . $filename);

            file_put_contents($path, $qrPng);


            $model->generate_qr_code = $filename;
        });



    }



    public function folder()
    {
        return $this->belongsTo(FolderModel::class, 'folder_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



}
