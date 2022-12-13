<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkTypeItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'work_type_id' => $this->work_type_id,
            'element_type_id' => $this->element_type_id,
            'description' => $this->description,
            
            // 'nos' => $this->when($this->element_type_id == 1 || $this->element_type_id == 2, $this->nos),
            // 'length' => $this->when($this->element_type_id == 1 || $this->element_type_id == 3, $this->length),
            // 'breadth' => $this->when($this->element_type_id == 1, $this->breadth),
            // 'height' => $this->when($this->element_type_id == 1, $this->height),
            // 'quantity' => $this->when($this->element_type_id == 1 || $this->element_type_id == 3, $this->quantity),
            // 'unit_id' => $this->when($this->element_type_id == 1, $this->unit_id),

            $this->mergeWhen($this->element_type_id == 1, [
                'nos' => $this->nos,
                'length' => $this->length,
                'breadth' => $this->breadth,
                'height' => $this->height,
                'quantity' => $this->quantity,
                'unit_id' => $this->unit_id,
            ]),
            $this->mergeWhen($this->element_type_id == 2, [
                'dia' => $this->dia,
                'rod_length' => $this->rod_length,
                'lap' => $this->lap,
                'matam' => $this->matam,
                'cutting_length' => $this->cutting_length,
                'nos' => $this->nos,
                'layer' => $this->layer,
                'item' => $this->item,
                'total_length' => $this->total_length,
                'unit_weight' => $this->unit_weight,
                'weight' => $this->weight,
            ]),

            // 'nos' => $this->nos,
            // 'length' => $this->length,
            // 'breadth' => $this->breadth,
            // 'height' => $this->height,
            // 'quantity' => $this->quantity,
            // 'total' => $this->total,
            // 'unit_id' => $this->unit_id,
        ];
    }
}
