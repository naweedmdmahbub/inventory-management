<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructureStoreUpdateRequest;
use App\Http\Resources\StructureResource;
use App\Laravue\Models\Structure;
use App\Laravue\Models\Work;
use App\Laravue\Models\WorkItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StructureController extends Controller
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
        $structureQuery = Structure::with('elementType');
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');
        if (!empty($keyword)) {
            $structureQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }
        return StructureResource::collection($structureQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StructureStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'description', 'element_type_id');
            // dd($request->input('works'), $request->works);
            DB::beginTransaction();
            $structure = Structure::create($input);
            foreach($request->works as $workInput){
                // dd($workInput);
                $this->saveWork($workInput, $structure);
            }
            DB::commit();
            return new StructureResource($structure);
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
        $structure = Structure::with('works.workItems')->find($id);
        // dd($structure);
        return new StructureResource($structure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StructureStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'description', 'element_type_id');
            $structure = Structure::find($id);
            DB::beginTransaction();
            $structure->fill($input)->update();
            if($request->deletedWorkIDs){
                $this->deleteWorks($request->deletedWorkIDs);
            }
            if($request->deletedWorkItemIDs){
                $this->deleteWorkItems($request->deletedWorkItemIDs);
            }

            foreach($request->works as $workInput){
                // dd($workInput);
                $this->saveWork($workInput, $structure);
            }
            DB::commit();
            return new StructureResource($structure);
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
            $structure = Structure::find($id);
            $structure->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }


    public function saveWork($workInput, $structure)
    {        
        $work = isset($workInput['id']) ? Work::find($workInput['id']) : new Work();
        $work->name = $workInput['name'];
        $work->total = isset($workInput['total']) ? $workInput['total'] :null;
        $work->structure_id = $structure->id;
        $work->save();
        foreach($workInput['workItems'] as $workItemInput){
            $workItem = isset($workItemInput['id']) ? WorkItem::find($workItemInput['id']) : new WorkItem();
            $workItem->work_id = $work->id;
            $this->saveWorkItem($workItem, $workItemInput);
        }
    }

    public function saveWorkItem($workItem, $input)
    {
        $workItem->element_type_id = $input['element_type_id'];
        $workItem->unit_id = $input['unit_id'];

        $workItem->description = $input['description'] ? $input['description'] :null;

        $workItem->nos = isset($input['nos']) ? $input['nos'] :null;
        $workItem->length = isset($input['length']) ? $input['length'] :null;
        $workItem->breadth = isset($input['breadth']) ? $input['breadth'] :null;
        $workItem->height = isset($input['height']) ? $input['height'] :null;
        $workItem->weight = isset($input['weight']) ? $input['weight'] :null;
        $workItem->quantity = isset($input['quantity']) ? $input['quantity'] :null;
        $workItem->total = isset($input['total']) ? $input['total'] :null;
        
        $workItem->dia = isset($input['dia']) ? $input['dia'] :null;
        $workItem->rod_length = isset($input['rod_length']) ? $input['rod_length'] :null;
        $workItem->lap = isset($input['lap']) ? $input['lap'] :null;
        $workItem->matam = isset($input['matam']) ? $input['matam'] : null;
        $workItem->cutting_length = isset($input['cutting_length']) ? $input['cutting_length'] : null;
        $workItem->item = isset($input['item']) ? $input['item'] : null;
        $workItem->layer = isset($input['layer']) ? $input['layer'] : null;
        $workItem->total_length = isset($input['total_length']) ? $input['total_length'] : null;
        $workItem->unit_weight = isset($input['unit_weight']) ? $input['unit_weight'] : null;
        $workItem->total_weight = isset($input['total_weight']) ? $input['total_weight'] : null;

        $workItem->pile = isset($input['pile']) ? $input['pile'] :null;
        $workItem->pile_dia = isset($input['pile_dia']) ? $input['pile_dia'] :null;
        $workItem->bar_dia = isset($input['bar_dia']) ? $input['bar_dia'] :null;
        $workItem->rebar_num = isset($input['rebar_num']) ? $input['rebar_num'] :null;
        $workItem->laping = isset($input['laping']) ? $input['laping'] :null;
        $workItem->actual_length = isset($input['actual_length']) ? $input['actual_length'] :null;
        $workItem->remarks = isset($input['remarks']) ? $input['remarks'] :null;

        $workItem->save();
    }


    public function deleteWorks($ids)
    {
        DB::table("work_items")->whereIn('work_id',$ids)->delete();
        DB::table("works")->whereIn('id',$ids)->delete();
    }
    
    public function deleteWorkItems($ids)
    {
        DB::table("work_items")->whereIn('id',$ids)->delete();
    }
}
