<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department_Update_Request;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return $this->customeResponse(DepartmentResource::collection($departments), "All Retrieve Departments Success", 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $department = Department::create([
                'name'                 => $request->name,
                'description'          => $request->description,

            ]);
            DB::commit();

            return $this->customeResponse(new DepartmentResource($department),'the Department created successfully',201);


        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->customeResponse(null,' the Department not created',500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        try {
            return $this->customeResponse(new DepartmentResource($department), 'ok', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Department_Update_Request $request, Department $department)
    {
        try {
            $newData = [];
            if (isset($request->name)) {
                $newData['name'] = $request->name;
            }
            if (isset($request->description)) {
                $newData['description'] = $request->description;
            }

            $department->update($newData);

            return $this->customeResponse(new DepartmentResource($department), 'Department Updated successfully', 200);

        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json(['message' => ' Error '], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        try {
            $department ->delete();
            return $this->customeResponse('', 'Department  deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }


    /* Implement soft deleting for departments , allowing them to be restored or permanently deleted. */

    public function restore( string $id)
    {
        Department::withTrashed()->find($id)->restore();
        return response()->json(['message' => 'Department restored']);
    }

    public function forceDelete( string $id)
    {
        Department::withTrashed()->find($id)->forceDelete();
        return response()->json(['message' => 'Department permanently deleted']);
    }
}
