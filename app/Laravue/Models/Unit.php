<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'code', 'status'];

    // Activity Logs
    protected static $logAttributes = ['name', 'code', 'status'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Unit has been {$eventName}";
    }
}
