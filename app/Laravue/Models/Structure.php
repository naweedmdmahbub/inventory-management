<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Structure extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'description', 'element_type_id'];

    public function works(){
        return $this->hasMany(Work::class);
    }
    public function elementType(){
        return $this->belongsTo(ElementType::class);
    }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'description', 'element_type_id'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Structure has been {$eventName}";
    }
    // Activity Logs ends
}
