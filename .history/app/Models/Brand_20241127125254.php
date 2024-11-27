<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'brands';

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
