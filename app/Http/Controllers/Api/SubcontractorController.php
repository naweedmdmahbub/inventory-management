<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcontractorStoreUpdateRequest;
use App\Http\Resources\SubcontractorResource;
use App\Laravue\Models\Subcontractor;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SubcontractorController extends Controller
{
    use ImageTrait;
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $subcontractorQuery = Subcontractor::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $subcontractorQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return SubcontractorResource::collection($subcontractorQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcontractorStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            DB::beginTransaction();
            $subcontractor = Subcontractor::create($input);
            DB::commit();
            return new SubcontractorResource($subcontractor);
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
        $subcontractor = Subcontractor::find($id);
        return new SubcontractorResource($subcontractor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcontractorStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            $subcontractor = Subcontractor::find($id);
            DB::beginTransaction();
            $subcontractor->fill($input)->update();
            DB::commit();
            return new SubcontractorResource($subcontractor);
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
            $subcontractor = Subcontractor::find($id);
            $subcontractor->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
