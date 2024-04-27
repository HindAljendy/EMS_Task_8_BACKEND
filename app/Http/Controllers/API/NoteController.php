<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note_Department_Request;
use App\Http\Requests\Note_Employee_Request;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::with('noteable')->get();
        return $this->customeResponse($notes, "All Retrieve Notes Success", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_note_department(Note_Department_Request $request , $department_id)
    {
        try {
            $department= Department::where('id',$department_id)->first();
            if (!$department) {
                return $this->customeResponse(null, 'Department not found', 404);
            }

            $note = $department->notes()->create([
                'note' => $request->note,
            ]);
            return $this->customeResponse($note, 'Note that special Department Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, "Error", 500);
        }
    }

    public function store_note_employee(Note_Employee_Request $request , $employee_id)
    {
        try {
            $employee= Employee::where('id',$employee_id)->first();
            if (!$employee) {
                return $this->customeResponse(null, 'Employee not found', 404);
            }
           $note = $employee->notes()->create([
                'note' => $request->note,
            ]);
            return $this->customeResponse($note, 'Note that special Employee Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, "Error", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        try {
            return $this->customeResponse($note, 'OK', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, "Error", 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        try {
            $newData = [];
            if (isset($request->note)) {
                $newData['note'] = $request->note;
            }
            $note->update($newData);
            return $this->customeResponse($note, 'note updated Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, "Error", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        try {
            $note->delete();
            return $this->customeResponse("", 'note deleted', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, "Error", 500);
        }
    }
}
