<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'categories';

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
