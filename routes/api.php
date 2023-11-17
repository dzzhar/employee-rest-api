<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
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

Route::middleware('auth:sanctum')->group(function () {

    // route get all resources
    Route::get('employees', [EmployeeController::class, 'index']);

    // route add resource
    Route::post('employees', [EmployeeController::class, 'store']);

    // route get detail resource
    Route::get('employees/{id}', [EmployeeController::class, 'show']);

    // route edit resource
    Route::put('employees/{id}', [EmployeeController::class, 'update']);

    // route delete resource
    Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);

    // route search resource by name
    Route::get('employees/search/{name}', [EmployeeController::class, 'search']);

    // route get active resource
    Route::get('employees/status/active', [EmployeeController::class, 'active']);

    // route get inactive resource
    Route::get('employees/status/inactive', [EmployeeController::class, 'inactive']);

    // route get terminated resource
    Route::get('employees/status/terminated', [EmployeeController::class, 'terminated']);
});

// route register
Route::post('register', [AuthController::class, 'register']);

// route login
Route::post('login', [AuthController::class, 'login']);
