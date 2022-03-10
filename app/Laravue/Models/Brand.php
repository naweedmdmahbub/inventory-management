<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Brand extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'code', 'description'];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // Activity Logs
    protected static $logAttributes = ['name', 'code', 'description'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Brand has been {$eventName}";
    }
}
