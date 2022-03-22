<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreUpdateRequest;
use App\Http\Resources\ClientResource;
use App\Laravue\Models\Client;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
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
        // dd('hi');
        $searchParams = $request->all();
        $clientQuery = Client::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $clientQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return ClientResource::collection($clientQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            DB::beginTransaction();
            $client = Client::create($input);
            DB::commit();
            return new ClientResource($client);
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
        $client = Client::find($id);
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            $client = Client::find($id);
            DB::beginTransaction();
            $client->fill($input)->update();
            DB::commit();
            return new ClientResource($client);
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
            $client = Client::find($id);
            $client->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
