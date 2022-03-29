<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierStoreUpdateRequest;
use App\Http\Resources\SupplierResource;
use App\Laravue\Models\Supplier;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
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
        $supplierQuery = Supplier::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $supplierQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return SupplierResource::collection($supplierQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            DB::beginTransaction();
            $supplier = Supplier::create($input);
            DB::commit();
            return new SupplierResource($supplier);
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
        $supplier = Supplier::find($id);
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            $supplier = Supplier::find($id);
            DB::beginTransaction();
            $supplier->fill($input)->update();
            DB::commit();
            return new SupplierResource($supplier);
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
            $supplier = Supplier::find($id);
            $supplier->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
