<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitStoreUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Laravue\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd('hi');
        $searchParams = $request->all();
        $unitQuery = Unit::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $unitQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return UnitResource::collection($unitQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStoreUpdateRequest $request)
    {
        try {
            $input = $request->only('name', 'code', 'description');
            DB::beginTransaction();
            $unit = Unit::create($input);
            DB::commit();
            return new UnitResource($unit);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitStoreUpdateRequest $request, $id)
    {
        try {
            $input = $request->only('name', 'code', 'description');
            $unit = Unit::find($id);
            // dd($request->all(), $input, $id, $unit);
            // $unit->name = $input['name'];
            // $unit->code = $input['code'];
            // $unit->description = $input['description'];
            DB::beginTransaction();
            $unit->fill($input)->update();
            // $unit->save();
            DB::commit();
            return new UnitResource($unit);
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
        // if (!auth()->user()->can('units.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // dd('hi',$id);
        
        try {
            $unit = Unit::find($id);
            $unit->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
