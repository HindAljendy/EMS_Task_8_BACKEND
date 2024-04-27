<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee_Update_Request;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return $this->customeResponse(EmployeeResource::collection($employees), "All Retrieve Employees Success", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::create([
                'first_name'         => $request->first_name,
                'last_name'          => $request->last_name,
                'email'              => $request->email,
                'position'           => $request->position,
                'department_id'      => $request->department_id,
            ]);
            DB::commit();

            return $this->customeResponse(new EmployeeResource($employee),'the Employee created successfully',201);


        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->customeResponse(null,' the Employee not created',500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        try {
            return $this->customeResponse(new EmployeeResource($employee), 'ok', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Employee_Update_Request $request,Employee $employee )
    {
        try {
            $newData = [];
            if (isset($request->first_name)) {
                $newData['first_name'] = $request->first_name;
            }
            if (isset($request->last_name)) {
                $newData['last_name'] = $request->last_name;
            }
            if (isset($request->email)) {
                $newData['email'] = $request->email;
            }
            if (isset($request->position)) {
                $newData['position'] = $request->position;
            }

            $employee->update($newData);

            return $this->customeResponse(new EmployeeResource($employee), 'Employee Updated successfully', 200);

        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json(['message' => ' Error '], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee ->delete();
            return $this->customeResponse('', 'Employee deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }

    }


    /* Implement soft deleting for employees, allowing them to be restored or permanently deleted. */

    public function restore( string $id)
    {
        Employee::withTrashed()->find($id)->restore();
        return response()->json(['message' => 'Employee restored']);
    }

    public function forceDelete( string $id)
    {
        Employee::withTrashed()->find($id)->forceDelete();
        return response()->json(['message' => 'Employee permanently deleted']);
    }

}
