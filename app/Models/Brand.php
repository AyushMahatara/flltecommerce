<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'brands';
    // public function getMediaDirectory(): string
    // {
    //     return 'brands';
    // }
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
