<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ElementType extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name'];

    // Activity Logs
    protected static $logAttributes = ['name'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Element Type has been {$eventName}";
    }
}
