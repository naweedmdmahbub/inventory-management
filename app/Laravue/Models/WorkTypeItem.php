<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkTypeItem extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'description', 'work_type_id', 'element_type_id',
                            'unit_id', 'nos', 'length', 'breadth', 'height', 'weight', 'quantity', 'total',
                            'dia', 'rod_length', 'lap', 'matam', 'cutting_length', 'item', 'layer', 'total_length', 'unit_weight', 'total_weight',
                            'pile', 'pile_dia', 'bar_dia', 'rebar_num', 'laping', 'actual_length', 'remarks'
                        ];

    public function workType(){
        return $this->belongsTo(WorkType::class);
    }
    // public function elementType(){
    //     return $this->belongsTo(ElementType::class);
    // }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'description', 'work_type_id', 'element_type_id',
                            'unit_id', 'nos', 'length', 'breadth', 'height', 'weight', 'quantity', 'total',
                            'dia', 'rod_length', 'lap', 'matam', 'cutting_length', 'item', 'layer', 'total_length', 'unit_weight', 'total_weight',
                            'pile', 'pile_dia', 'bar_dia', 'rebar_num', 'laping', 'actual_length', 'remarks'
                        ];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "WorkTypeItem has been {$eventName}";
    }
    // Activity Logs ends
}
