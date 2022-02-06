<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $guard_name = 'api';
    protected $fillable = [
        'name', 'image', 'code', 'description',
    ];
}
