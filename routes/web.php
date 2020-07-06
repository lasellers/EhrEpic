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
    return view('welcome', ['name' => 'EHR EPIC']);
})->name('home');

Route::get('/emails/patient-summary-notification', function () {
    return view('emails.patient-summary-notification', ['name' => 'EHR EPIC']);
});
