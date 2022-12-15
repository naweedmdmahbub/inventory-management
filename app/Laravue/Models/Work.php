<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Work extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'structure_type_id', 'total'];

    public function workItems(){
        return $this->hasMany(WorkItem::class);
    }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'structure_type_id', 'total'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Work has been {$eventName}";
    }
    // Activity Logs ends
}
