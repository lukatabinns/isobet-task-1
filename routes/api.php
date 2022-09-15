<?php

use App\Http\Controllers\AccessManagement\PermissionController;
use App\Http\Controllers\AccessManagement\RoleController;
use App\Http\Controllers\AccessManagement\UserController;
use App\Http\Controllers\Inputs\InputsController;
use App\Http\Controllers\Lists\ListsController;
use App\Http\Controllers\Outputs\OutputsController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Imports\ImportsController;
use App\Http\Controllers\System\SystemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('Auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/store', [StudentController::class, 'store']);
Route::post('/update/{id}', [StudentController::class, 'update']);
Route::get('/students', [StudentController::class, 'getStudents']);
Route::get('/student/{id}', [StudentController::class, 'getStudent']);
