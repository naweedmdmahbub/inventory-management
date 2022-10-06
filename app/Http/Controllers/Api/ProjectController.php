<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Laravue\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
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
        $projectQuery = Project::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $projectQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return ProjectResource::collection($projectQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'client_id', 'code', 'location', 'description', 'start_date', 'end_date');
            DB::beginTransaction();
            $project = Project::create($input);
            DB::commit();
            return new ProjectResource($project);
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
        $project = Project::find($id);
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address');
            $project = Project::find($id);
            DB::beginTransaction();
            $project->fill($input)->update();
            DB::commit();
            return new ProjectResource($project);
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
            $project = Project::find($id);
            $project->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
