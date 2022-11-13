<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StructureType extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'description', 'element_type_id'];

    public function workTypes(){
        return $this->hasMany(WorkType::class);
    }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'description', 'element_type_id'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "StructureType has been {$eventName}";
    }
    // Activity Logs ends
}
