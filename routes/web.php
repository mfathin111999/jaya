<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('public/home');
})->name('home');

Route::get('/login', function(){
	return view('public.login');
})->name('login');

Route::get('/home', function(){
	return view('public.home');
})->name('home');

Route::get('/profile', function(){
	return view('public.profile');
})->name('profile');

Route::get('/service', function(){
	return view('public.service');
})->name('service');

Route::get('/reservation', function(){
	return view('public.reservation');
})->name('reservation');

Route::get('/portofolio', function(){
	return view('public.portofolio');
})->name('portofolio');

Route::get('/consult', function(){
	return view('public.consult');
})->name('consult');

Route::get('/history', function(){
	return view('public.history');
})->name('history');

Route::get('/dashboard', function(){
	return view('admin.dashboard');
})->name('dashboard');

Route::get('/calendar', function(){
	return view('admin.calendar');
})->name('calendar');

Route::get('/engagement', function(){
	return view('admin.engagement');
})->name('engagement');

Route::get('/work', function(){
	return view('admin.work');
})->name('work');

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
	return view('admin.reportsurvey', compact('id'));
})->name('survei');