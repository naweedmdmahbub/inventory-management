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
        $structureTypeQuery = StructureType::query();
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
            $structureTypeInput = $request->only('name', 'description', 'element_type_id');
            DB::beginTransaction();
            $structureType = StructureType::create($structureTypeInput);
            foreach($request->workTypes as $workTypeInput){
                $workTypeArr['name'] = $workTypeInput['name'];
                $workTypeArr['total'] = isset($workTypeInput['total']) ? $workTypeInput['total'] :null;
                $workTypeArr['structure_type_id'] = $structureType->id;
                // dd($workType);
                $workType = WorkType::create($workTypeArr);
                foreach($workTypeInput['workTypeItems'] as $workTypeItemInput){
                    $workTypeItem['work_type_id'] = $workType->id;
                    $workTypeItem['element_type_id'] = $workTypeItemInput['element_type_id'];
                    $workTypeItem['unit_id'] = $workTypeItemInput['unit_id'];

                    $workTypeItem['name'] = $workTypeItemInput['name'] ? $workTypeItemInput['name'] :null;
                    $workTypeItem['description'] = $workTypeItemInput['description'] ? $workTypeItemInput['description'] :null;

                    $workTypeItem['nos'] = isset($workTypeItemInput['nos']) ? $workTypeItemInput['nos'] :null;
                    $workTypeItem['length'] = isset($workTypeItemInput['length']) ? $workTypeItemInput['length'] :null;
                    $workTypeItem['breadth'] = isset($workTypeItemInput['breadth']) ? $workTypeItemInput['breadth'] :null;
                    $workTypeItem['height'] = isset($workTypeItemInput['height']) ? $workTypeItemInput['height'] :null;
                    $workTypeItem['weight'] = isset($workTypeItemInput['weight']) ? $workTypeItemInput['weight'] :null;
                    $workTypeItem['quantity'] = isset($workTypeItemInput['quantity']) ? $workTypeItemInput['quantity'] :null;
                    $workTypeItem['total'] = isset($workTypeItemInput['total']) ? $workTypeItemInput['total'] :null;
                    
                    $workTypeItem['dia'] = isset($workTypeItemInput['dia']) ? $workTypeItemInput['dia'] :null;
                    $workTypeItem['rod_length'] = isset($workTypeItemInput['rod_length']) ? $workTypeItemInput['rod_length'] :null;
                    $workTypeItem['lap'] = isset($workTypeItemInput['lap']) ? $workTypeItemInput['lap'] :null;
                    $workTypeItem['matam'] = isset($workTypeItemInput['matam']) ? $workTypeItemInput['matam'] : null;
                    $workTypeItem['cutting_length'] = isset($workTypeItemInput['cutting_length']) ? $workTypeItemInput['cutting_length'] : null;
                    $workTypeItem['item'] = isset($workTypeItemInput['item']) ? $workTypeItemInput['item'] : null;
                    $workTypeItem['layer'] = isset($workTypeItemInput['layer']) ? $workTypeItemInput['layer'] : null;
                    $workTypeItem['total_length'] = isset($workTypeItemInput['total_length']) ? $workTypeItemInput['total_length'] : null;
                    $workTypeItem['unit_weight'] = isset($workTypeItemInput['unit_weight']) ? $workTypeItemInput['unit_weight'] : null;
                    $workTypeItem['total_weight'] = isset($workTypeItemInput['total_weight']) ? $workTypeItemInput['total_weight'] : null;

                    $workTypeItem['pile'] = isset($workTypeItemInput['pile']) ? $workTypeItemInput['pile'] :null;
                    $workTypeItem['pile_dia'] = isset($workTypeItemInput['pile_dia']) ? $workTypeItemInput['pile_dia'] :null;
                    $workTypeItem['bar_dia'] = isset($workTypeItemInput['bar_dia']) ? $workTypeItemInput['bar_dia'] :null;
                    $workTypeItem['rebar_num'] = isset($workTypeItemInput['rebar_num']) ? $workTypeItemInput['rebar_num'] :null;
                    $workTypeItem['laping'] = isset($workTypeItemInput['laping']) ? $workTypeItemInput['laping'] :null;
                    $workTypeItem['actual_length'] = isset($workTypeItemInput['actual_length']) ? $workTypeItemInput['actual_length'] :null;
                    $workTypeItem['remarks'] = isset($workTypeItemInput['remarks']) ? $workTypeItemInput['remarks'] :null;

                    // dd($workTypeItem);
                    WorkTypeItem::create($workTypeItem);
                }    
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
        $structureType = StructureType::find($id);
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
            $input = $request->only('name', 'client_id', 'code', 'location', 'description', 'start_date', 'end_date');
            $structureType = StructureType::find($id);
            DB::beginTransaction();
            $structureType->fill($input)->update();
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
}
