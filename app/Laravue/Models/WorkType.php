<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkType extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'structure_type_id'];

    public function workTypeItems(){
        return $this->hasMany(WorkTypeItem::class);
    }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'structure_type_id'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "WorkType has been {$eventName}";
    }
    // Activity Logs ends
}
