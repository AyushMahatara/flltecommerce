<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

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
