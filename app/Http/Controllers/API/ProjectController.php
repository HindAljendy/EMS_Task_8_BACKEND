<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('employees')->get();
        return $this->customeResponse($projects,"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            $project = Project::create([
                'name' =>$request->name,
            ]);
            if (isset($request->employee_id)){
                $project->employees()->attach($request->employee_id);
            }
            return $this->customeResponse($project, 'project Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error",500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            return $this->customeResponse($project, 'Done', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            $newData = [];
            if (isset($request->name)) {
                $newData['name'] = $request->name;
            }
            $project->update($newData);
            if (isset($request->employee_id)){
                $project->employees()->sync($request->employee_id);
            }
            return $this->customeResponse($project, 'project updated Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->employees()->detach();
            $project->delete();
            return $this->customeResponse("", 'Project deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error",500);
        }

    }
}
