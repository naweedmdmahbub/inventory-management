<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkItemResource extends JsonResource
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
            'work_id' => $this->work_id,
            'element_type_id' => $this->element_type_id,
            'description' => $this->description,

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
