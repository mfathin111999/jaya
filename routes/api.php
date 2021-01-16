<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ResourceController;
use App\Http\Controllers\API\V1\ServiceController;
use App\Http\Controllers\API\V1\ReservationController;
use App\Http\Controllers\API\V1\EngagementController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\EmployeeController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/province', [ResourceController::class, 'getProvince']);
Route::post('/district', [ResourceController::class, 'getDistrict']);
Route::post('/village', [ResourceController::class, 'getVillage']);
Route::post('/regency', [ResourceController::class, 'getRegency']);
Route::get('/resource', [ResourceController::class, 'index']);
Route::post('/resource/create-step', [ResourceController::class, 'createStep']);
Route::post('/resource/create-resource', [ResourceController::class, 'createResource']);
Route::get('/resource/{id}', [ResourceController::class, 'view']);
Route::post('/resource/update-step/{id}', [ResourceController::class, 'updateStep']);
Route::post('/resource/update-resource/{id}', [ResourceController::class, 'updateResource']);
Route::post('/resource/destroy/{id}', [ResourceController::class, 'destroy']);

Route::get('/service', [ServiceController::class, 'index']);
Route::post('/service/create-service', [ServiceController::class, 'createService']);
Route::get('/service/{id}', [ServiceController::class, 'view']);
Route::post('/service/update-service/{id}', [ServiceController::class, 'updateService']);
Route::post('/service/destroy/{id}', [ServiceController::class, 'destroy']);

Route::get('/reservation', [ReservationController::class, 'index']);
Route::post('/reservation/create-reservation', [ReservationController::class, 'createReservation']);
Route::post('/reservation/{id}', [ReservationController::class, 'view']);
Route::post('/reservation/update-reservation/{id}', [ReservationController::class, 'updateReservation']);
Route::post('/reservation/destroy/{id}', [ReservationController::class, 'destroy']);

Route::get('/engagement', [EngagementController::class, 'index']);
Route::get('/engagement/availableDate', [EngagementController::class, 'getAvailableDate']);
Route::get('/engagement/{id}', [EngagementController::class, 'view']);
Route::post('/engagement/create-engagement', [EngagementController::class, 'createEngagement']);
Route::post('/engagement/acc', [EngagementController::class, 'acc']);
Route::post('/engagement/ignore', [EngagementController::class, 'ignore']);
Route::post('/engagement/finish', [EngagementController::class, 'finish']);
Route::post('/engagement/update-engagement/{id}', [EngagementController::class, 'updateEngagement']);
Route::post('/engagement/destroy/{id}', [EngagementController::class, 'destroy']);

Route::get('/notification', [NotificationController::class, 'index']);
Route::post('/notification/create-notification', [NotificationController::class, 'createNotification']);
Route::post('/notification/{id}', [NotificationController::class, 'view']);
Route::post('/notification/update-notification/{id}', [NotificationController::class, 'updateNotification']);
Route::post('/notification/destroy/{id}', [NotificationController::class, 'destroy']);

Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee/create-employee', [EmployeeController::class, 'createEmployee']);
Route::post('test', [EmployeeController::class, 'test']);
Route::get('/employee/{id}', [EmployeeController::class, 'view']);
Route::post('/employee/update-employee/{id}', [EmployeeController::class, 'updateEmployee']);
Route::post('/employee/destroy/{id}', [EmployeeController::class, 'destroy']);