<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ResourceController;
use App\Http\Controllers\API\V1\ServiceController;
use App\Http\Controllers\API\V1\ReservationController;
use App\Http\Controllers\API\V1\EngagementController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\ReportController;
use App\Http\Controllers\API\V1\PaymentController;

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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/engagement', [EngagementController::class, 'index']);
Route::post('/engagementSurveyer', [EngagementController::class, 'indexSurveyer']);
Route::post('/engagementMandor', [EngagementController::class, 'indexMandor']);
Route::post('/engagementVendor', [EngagementController::class, 'indexVendor']);
Route::post('/engagementCustomer', [EngagementController::class, 'indexCustomer']);
Route::get('/engagement/availableDate', [EngagementController::class, 'getAvailableDate']);
Route::get('/engagement/getCalendarData', [EngagementController::class, 'getCalendarData']);
Route::get('/engagement/getByCode/{code}', [EngagementController::class, 'getByCode']);
Route::get('/engagement/{id}', [EngagementController::class, 'view']);
Route::get('/engagement/getBy/{id}', [EngagementController::class, 'getById']);
Route::post('/engagement/getCalendarDataSurveyer', [EngagementController::class, 'getCalendarDataSurveyer']);
Route::post('/engagement/getCalendarDataMandor', [EngagementController::class, 'getCalendarDataMandor']);
Route::post('/engagement/dealed/{id}', [EngagementController::class, 'dealed']);
Route::post('/engagement/addVendor', [EngagementController::class, 'addVendor']);
Route::post('/engagement/create-engagement', [EngagementController::class, 'createEngagement']);
Route::post('/engagement/action', [EngagementController::class, 'action']);
Route::post('/engagement/ignore', [EngagementController::class, 'ignore']);
Route::post('/engagement/finish', [EngagementController::class, 'finish']);
Route::post('/engagement/accVendor/{id}', [EngagementController::class, 'accVendor']);
Route::get('/engagement/accCustomer/{id}', [EngagementController::class, 'accCustomer']);
Route::post('/engagement/update-engagement/{id}', [EngagementController::class, 'updateEngagement']);
Route::post('/engagement/destroy/{id}', [EngagementController::class, 'destroy']);


Route::get('/termin/getByEngagementId/{id}', [PaymentController::class, 'getByEngagementId']);
Route::get('/termin/view/{id}', [PaymentController::class, 'view']);
Route::post('/termin', [PaymentController::class, 'store']);
Route::post('/termin/addToTermin', [PaymentController::class, 'addToTermin']);
Route::post('/termin/update', [PaymentController::class, 'update']);
Route::post('/termin/destroy/{id}', [PaymentController::class, 'destroy']);

Route::post('/payment/notification', [PaymentController::class, 'notification']);
Route::get('/payment/complete', [PaymentController::class, 'completed']);
Route::get('/payment/unfinish', [PaymentController::class, 'unfinish']);
Route::get('/payment/finish', [PaymentController::class, 'finish']);
Route::get('/payment/failed', [PaymentController::class, 'failed']);


Route::get('/notification', [NotificationController::class, 'index']);
Route::post('/notification/create-notification', [NotificationController::class, 'createNotification']);
Route::post('/notification/{id}', [NotificationController::class, 'view']);
Route::post('/notification/update-notification/{id}', [NotificationController::class, 'updateNotification']);
Route::post('/notification/destroy/{id}', [NotificationController::class, 'destroy']);

// Route::middleware('auth:api')->group(function(){
	Route::post('/service/create-service', [ServiceController::class, 'createService']);
	Route::get('/service/{id}', [ServiceController::class, 'view']);
	Route::post('/service/update-service/{id}', [ServiceController::class, 'updateService']);
	Route::post('/service/destroy/{id}', [ServiceController::class, 'destroy']);

	Route::get('/reservation', [ReservationController::class, 'index']);
	Route::post('/reservation/create-reservation', [ReservationController::class, 'createReservation']);
	Route::post('/reservation/{id}', [ReservationController::class, 'view']);
	Route::post('/reservation/update-reservation/{id}', [ReservationController::class, 'updateReservation']);
	Route::post('/reservation/destroy/{id}', [ReservationController::class, 'destroy']);

	Route::get('/employee', [EmployeeController::class, 'index']);
	Route::post('/employee/create-employee', [EmployeeController::class, 'createEmployee']);
	Route::get('/employee/{id}', [EmployeeController::class, 'view']);
	Route::post('/employee/update-employee/{id}', [EmployeeController::class, 'updateEmployee']);
	Route::post('/employee/destroy/{id}', [EmployeeController::class, 'destroy']);

	Route::get('/vendor/getProgress', [EmployeeController::class, 'getProgress'])->middleware('auth:api');
	Route::get('/vendor/getPayment', [EmployeeController::class, 'getPayment'])->middleware('auth:api');
	Route::get('/vendor/getProgressCustomer', [EmployeeController::class, 'getProgressCustomer']);
	Route::get('/vendor/getPaymentCustomer', [EmployeeController::class, 'getPaymentCustomer']);
	Route::get('/vendor/allBusiness', [EmployeeController::class, 'allBusiness']);
	Route::get('/vendor/allVendor', [EmployeeController::class, 'allVendor']);
	Route::post('/vendor/create-vendor', [EmployeeController::class, 'createVendor']);
	Route::get('/vendor/{id}', [EmployeeController::class, 'viewVendor']);
	Route::post('/vendor/update-vendor/{id}', [EmployeeController::class, 'updateVendor']);
	Route::post('/vendor/destroy/{id}', [EmployeeController::class, 'destroyVendor']);

	Route::post('/vendor/history', [EngagementController::class, 'historyVendor']);
	Route::post('/vendor/report/{id}', [ReportController::class, 'setVendor']);
	Route::post('/vendor/report-step/{id}', [ReportController::class, 'setVendorAll']);

	Route::post('/mandor/action/{id}', [ReportController::class, 'mandorAction']);

	Route::post('/supervisor/addPay/{id}', [ReportController::class, 'addPay']);
	Route::post('/supervisor/addCheckout/{id}', [PaymentController::class, 'addCheckout']);
	Route::post('/supervisor/history', [EngagementController::class, 'historySupervisor']);

	Route::post('/customer/history', [EngagementController::class, 'historyCustomer']);


	Route::post('/partner', [EmployeeController::class, 'createPartner']);

	Route::get('/report', [ReportController::class, 'index']);
	Route::get('/report/getByIdEngagement/{id}', [ReportController::class, 'getByIdEngagement']);
	Route::get('/report/getByIdReport/{id}', [ReportController::class, 'getByIdReport']);
	Route::get('/report/getByIdReportStep/{id}', [ReportController::class, 'getByIdReportStep']);
	Route::get('/report/getCount/{id}', [ReportController::class, 'getCount']);
	Route::get('/report/{id}', [ReportController::class, 'view']);
	Route::post('/report/create', [ReportController::class, 'create']);
	Route::post('/report/store', [ReportController::class, 'store']);
	Route::post('/report/delStep', [ReportController::class, 'delStep']);
	Route::post('/report/updateStep', [ReportController::class, 'updateStep']);
	Route::post('/report/addDate', [ReportController::class, 'addDate']);
	Route::post('/report/addPrice', [ReportController::class, 'addPrice']);
	Route::post('/report/addTermin', [ReportController::class, 'addTermin']);
	Route::post('/report/addImage', [ReportController::class, 'addImage']);
	Route::post('/report/delImage', [ReportController::class, 'delImage']);
	Route::post('/report/update', [ReportController::class, 'updateReport']);
	Route::post('/report/destroy/{id}', [ReportController::class, 'destroy']);

	Route::get('/resource', [ResourceController::class, 'index']);
	Route::get('/resource/all-unit', [ResourceController::class, 'allUnit']);
	Route::post('/resource/create-unit', [ResourceController::class, 'createUnit']);
	Route::get('/resource/{id}', [ResourceController::class, 'view']);
	Route::post('/resource/update-unit/{id}', [ResourceController::class, 'updateUnit']);
	Route::post('/resource/destroy/{id}', [ResourceController::class, 'destroy']);

	Route::get('/user/getSurveyerById/{id}', [UserController::class, 'getSurveyerById']);
	Route::get('/user/getSurveyer', [UserController::class, 'getSurveyer']);
	Route::get('/user/getMandor', [UserController::class, 'getMandor']);
	Route::get('/user/getVendor', [UserController::class, 'getVendor']);
	Route::post('/user/getMe', [UserController::class, 'getMe']);
	Route::post('/user/createWorker', [UserController::class, 'registerSurveyer']);
	Route::post('/user/updateWorker/{id}', [UserController::class, 'updateSurveyer']);
	Route::post('/user/createMandor', [UserController::class, 'registerSurveyer']);
	Route::post('/user/updateMandor/{id}', [UserController::class, 'updateSurveyer']);
	Route::post('/user/actionSurveyer/{id}', [UserController::class, 'actionSurveyer']);
// });

Route::get('/service', [ServiceController::class, 'index']);


Route::get('/province', [ResourceController::class, 'getProvince']);
Route::post('/district', [ResourceController::class, 'getDistrict']);
Route::post('/village', [ResourceController::class, 'getVillage']);
Route::post('/regency', [ResourceController::class, 'getRegency']);
