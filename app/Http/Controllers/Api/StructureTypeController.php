<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructureTypeStoreUpdateRequest;
use App\Http\Resources\StructureTypeResource;
use App\Laravue\Models\StructureType;
use App\Laravue\Models\WorkType;
use App\Laravue\Models\WorkTypeItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StructureTypeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $structureTypeQuery = StructureType::with('elementType');
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');
        if (!empty($keyword)) {
            $structureTypeQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }
        return StructureTypeResource::collection($structureTypeQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StructureTypeStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'description', 'element_type_id');
            // dd($request->input('workTypes'), $request->workTypes);
            DB::beginTransaction();
            $structureType = StructureType::create($input);
            foreach($request->workTypes as $workTypeInput){
                // dd($workTypeInput);
                $this->saveWorkType($workTypeInput, $structureType);
            }
            DB::commit();
            return new StructureTypeResource($structureType);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $structureType = StructureType::with('workTypes.workTypeItems')->find($id);
        // dd($structureType);
        return new StructureTypeResource($structureType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StructureTypeStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'description', 'element_type_id');
            $structureType = StructureType::find($id);
            DB::beginTransaction();
            $structureType->fill($input)->update();
            if($request->deletedWorkTypeIDs){
                $this->deleteWorkTypes($request->deletedWorkTypeIDs);
            }
            if($request->deletedWorkTypeItemIDs){
                $this->deleteWorkTypeItems($request->deletedWorkTypeItemIDs);
            }

            foreach($request->workTypes as $workTypeInput){
                // dd($workTypeInput);
                $this->saveWorkType($workTypeInput, $structureType);
            }
            DB::commit();
            return new StructureTypeResource($structureType);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $structureType = StructureType::find($id);
            $structureType->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }


    public function saveWorkType($workTypeInput, $structureType)
    {        
        $workType = isset($workTypeInput['id']) ? WorkType::find($workTypeInput['id']) : new WorkType();
        $workType->name = $workTypeInput['name'];
        $workType->total = isset($workTypeInput['total']) ? $workTypeInput['total'] :null;
        $workType->structure_type_id = $structureType->id;
        $workType->save();
        foreach($workTypeInput['workTypeItems'] as $workTypeItemInput){
            $workTypeItem = isset($workTypeItemInput['id']) ? WorkTypeItem::find($workTypeItemInput['id']) : new WorkTypeItem();
            $workTypeItem->work_type_id = $workType->id;
            $this->saveWorkTypeItem($workTypeItem, $workTypeItemInput);
        }
    }

    public function saveWorkTypeItem($workTypeItem, $input)
    {
        $workTypeItem->element_type_id = $input['element_type_id'];
        $workTypeItem->unit_id = $input['unit_id'];

        $workTypeItem->description = $input['description'] ? $input['description'] :null;

        $workTypeItem->nos = isset($input['nos']) ? $input['nos'] :null;
        $workTypeItem->length = isset($input['length']) ? $input['length'] :null;
        $workTypeItem->breadth = isset($input['breadth']) ? $input['breadth'] :null;
        $workTypeItem->height = isset($input['height']) ? $input['height'] :null;
        $workTypeItem->weight = isset($input['weight']) ? $input['weight'] :null;
        $workTypeItem->quantity = isset($input['quantity']) ? $input['quantity'] :null;
        $workTypeItem->total = isset($input['total']) ? $input['total'] :null;
        
        $workTypeItem->dia = isset($input['dia']) ? $input['dia'] :null;
        $workTypeItem->rod_length = isset($input['rod_length']) ? $input['rod_length'] :null;
        $workTypeItem->lap = isset($input['lap']) ? $input['lap'] :null;
        $workTypeItem->matam = isset($input['matam']) ? $input['matam'] : null;
        $workTypeItem->cutting_length = isset($input['cutting_length']) ? $input['cutting_length'] : null;
        $workTypeItem->item = isset($input['item']) ? $input['item'] : null;
        $workTypeItem->layer = isset($input['layer']) ? $input['layer'] : null;
        $workTypeItem->total_length = isset($input['total_length']) ? $input['total_length'] : null;
        $workTypeItem->unit_weight = isset($input['unit_weight']) ? $input['unit_weight'] : null;
        $workTypeItem->total_weight = isset($input['total_weight']) ? $input['total_weight'] : null;

        $workTypeItem->pile = isset($input['pile']) ? $input['pile'] :null;
        $workTypeItem->pile_dia = isset($input['pile_dia']) ? $input['pile_dia'] :null;
        $workTypeItem->bar_dia = isset($input['bar_dia']) ? $input['bar_dia'] :null;
        $workTypeItem->rebar_num = isset($input['rebar_num']) ? $input['rebar_num'] :null;
        $workTypeItem->laping = isset($input['laping']) ? $input['laping'] :null;
        $workTypeItem->actual_length = isset($input['actual_length']) ? $input['actual_length'] :null;
        $workTypeItem->remarks = isset($input['remarks']) ? $input['remarks'] :null;

        $workTypeItem->save();
    }


    public function deleteWorkTypes($ids)
    {
        DB::table("work_type_items")->whereIn('work_type_id',$ids)->delete();
        DB::table("work_types")->whereIn('id',$ids)->delete();
    }
    
    public function deleteWorkTypeItems($ids)
    {
        DB::table("work_type_items")->whereIn('id',$ids)->delete();
    }
}
