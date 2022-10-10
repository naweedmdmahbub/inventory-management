<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructureTypeStoreUpdateRequest;
use App\Http\Resources\StructureTypeResource;
use App\Laravue\Models\StructureType;
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
        dd($request->all());
        try {
            $input = $request->only('name', 'client_id', 'code', 'location', 'description', 'start_date', 'end_date');
            DB::beginTransaction();
            $structureType = StructureType::create($input);
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
