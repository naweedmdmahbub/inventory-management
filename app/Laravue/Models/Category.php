<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guard_name = 'api';
    protected $fillable = [
        'name', 'code',
    ];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
