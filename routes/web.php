<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\ReportController;
use App\Http\Controllers\API\V1\EngagementController;
use App\Http\Controllers\API\V1\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/report/sendEngagement/{id}', [ReportController::class, 'sendPDFCustomer']);
Route::get('/report/printEngagement/{id}', [ReportController::class, 'printPDF']);
Route::get('/report/printOrderCustomer/{id}', [ReportController::class, 'printPDFCustomer']);
Route::get('/report/printVendor/{id}', [ReportController::class, 'printPDFVendor']);

Route::get('/', function () {
    return view('public/home');
})->name('home');

Route::get('/login', function(){
	if (Auth::check()) {
		return redirect()->route('home');
	}
	return view('public.login');
})->name('login');

Route::get('/forgot', [AuthController::class, 'forgot']);

Route::get('/home', function(){
	return view('public.home');
})->name('home');

Route::get('/action', function(){
	return view('public.partial.success');
})->name('action');

Route::get('/profile', function(){
	return view('public.profile');
})->name('profile');

Route::get('pay/failed', function(){
	return view('public.partial.failed');
})->name('failed');

Route::get('pay/finish', function(){
	return view('public.partial.finish');
})->name('finish');


Route::middleware('auth')->group(function(){

	Route::get('/history/all', function(){
		return view('public.history');
	})->name('history.all');

	Route::get('/history/detail/{id}', function($id){
		return view('public.history_detail', compact('id'));
	})->name('history.detail');

	Route::get('/dashboard', function(){
		return view('admin.dashboard');
	})->name('dashboard');

	Route::get('/calendar', function(){
		return view('admin.calendar');
	})->name('calendar');

	Route::get('/engagement', function(){
		return view('admin.engagement');
	})->name('engagement');

	Route::get('/engagement_vendor', function(){
		return view('admin.engagement_vendor');
	})->name('engagement_vendor');

	Route::get('/work', function(){
		return view('admin.work');
	})->name('work');

	Route::get('/vendor', function(){
		return view('admin.vendor');
	})->name('vendor');

	Route::get('/report', function(){
		return view('admin.report');
	})->name('report');

	Route::get('/setting_user', function(){
		return view('admin.setting_user');
	})->name('setting_user');

	Route::get('/statistic', function(){
		return view('admin.statistic');
	})->name('statistic');

	Route::get('/resource', function(){
		return view('admin.resource');
	})->name('resource');

	Route::get('/service', function(){
		return view('admin.service');
	})->name('adminservice');

	Route::get('/setting_account', function(){
		return view('admin.setting_account');
	})->name('setting_account');

	Route::get('/setting_application', function(){
		return view('admin.setting_application');
	})->name('setting_application');

	Route::get('/report_survey/{id}', function($id){
		return view('admin.report_surveyer_survey', compact('id'));
	})->name('survei');

	Route::get('/report_vendor/{id}', function($id){
		return view('admin.report_vendor_view', compact('id'));
	})->name('vendor.view');

	Route::get('/report_vendor_action/{id}', function($id){
		return view('admin.report_vendor_action', compact('id'));
	})->name('vendor.action');

	Route::get('/report_mandor/{id}', function($id){
		return view('admin.report_mandor_action', compact('id'));
	})->name('mandor.action');

	Route::get('/report_view/{id}', function($id){
		return view('admin.report_supervisor_view', compact('id'));
	})->name('supervisor.view');

	Route::get('/report_supervisor_action/{id}', function($id){
		return view('admin.report_supervisor_action', compact('id'));
	})->name('supervisor.view');

	Route::get('/debt_supervisor_card_vendor', function(){
		return view('admin.debt_supervisor_card_vendor');
	})->name('supervisor.debt.card.vendor');

	// Route::get('/debt_supervisor_card_all', function(){
	// 	return view('admin.debt_supervisor_card_all');
	// })->name('supervisor.debt.card.all');

	Route::get('/debt_supervisor_card_user', function(){
		return view('admin.debt_supervisor_card_user');
	})->name('supervisor.debt.card.user');

	Route::get('/debt_vendor_card', function(){
		return view('admin.debt_vendor_card');
	})->name('vendor.debt.card');

	Route::get('/debt_customer_card', function(){
		return view('admin.debt_customer_card');
	})->name('customer.debt.card');

	Route::get('/payment_supervisor_vendor', function(){
		return view('admin.payment_supervisor_vendor');
	})->name('supervisor.payment.vendor');

	Route::get('/payment_supervisor_user', function(){
		return view('admin.payment_supervisor_user');
	})->name('supervisor.payment.user');

	Route::get('/payment_vendor_card', function(){
		return view('admin.payment_vendor_card');
	})->name('vendor.payment.card');

	Route::get('/payment_customer_card', function(){
		return view('admin.payment_customer_card');
	})->name('customer.payment.card');

});



Route::get('/engagement/accCustomer/{id}', [EngagementController::class, 'accCustomer']);
Route::get('/engagement/accVendor/{id}', [EngagementController::class, 'accVendor']);