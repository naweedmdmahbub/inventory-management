<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'client_id', 'code', 'location', 'location', 'description', 'start_date', 'end_date', 'status'];

    // Activity Logs begins
    protected static $logAttributes = ['name', 'client_id', 'code', 'location', 'location', 'description', 'start_date', 'end_date', 'status'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Project has been {$eventName}";
    }
    // Activity Logs ends
}
