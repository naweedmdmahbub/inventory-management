<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkTypeItem extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'work_type_id', 'description', 'unit_id', 'nos', 'length', 'breadth', 'height', 'weight', 'quantity', 'total'];

    public function workType(){
        return $this->belongsTo(WorkType::class);
    }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'work_type_id', 'description', 'unit_id', 'nos', 'length', 'breadth', 'height', 'weight', 'quantity', 'total'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "WorkTypeItem has been {$eventName}";
    }
    // Activity Logs ends
}
