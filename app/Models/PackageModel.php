<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageModel extends Model
{
    use HasFactory;
    protected $table = 'package';
    protected $guarded = [];

    protected $casts = [
        'feature' => 'array',
    ];

    public function features()
    {
        return $this->belongsToMany(
            FeaturesModel::class,
            'package_features',
            'package_id',
            'feature_id'
        )->withPivot('is_enabled');
    }

}
