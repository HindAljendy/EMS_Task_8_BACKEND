<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\API\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware("auth:api");
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware("auth:api");
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware("auth:api");
});

Route::middleware("auth:api")->group(function () {

    /* Routes For DepartmentController */
    Route::apiResource('departments',DepartmentController::class);

    Route::delete('departments/{id}/forcedelete', [DepartmentController::class, 'forceDelete']);
    Route::patch('departments/{id}/restore', [DepartmentController::class, 'restore']);

    /* Routes For  EmployeeController */
    Route::apiResource('employees',EmployeeController::class);

    Route::delete('employees/{id}/forcedelete', [EmployeeController::class, 'forceDelete']);
    Route::patch('employees/{id}/restore', [EmployeeController::class, 'restore']);


    /* Routes For  ProjectController */
    Route::apiResource('projects',ProjectController::class);



    /* Routes For  NoteController */
    Route::get('/note',[NoteController::class, 'index']);
    Route::get('/note/{note}',[NoteController::class, 'show']);
    Route::put('/note/{note}',[NoteController::class, 'update']);
    Route::delete('/note/{note}',[NoteController::class, 'destroy']);

    Route::post('/employee_note/{employee}',[NoteController::class, 'store_note_employee']);
    Route::post('/department_note/{department}',[NoteController::class, 'store_note_department']);




});

