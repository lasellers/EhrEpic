<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('patients', 'PatientController@getPatients');
Route::get('patient/{id}', 'PatientController@getPatient');

Route::get('practitioners', 'PractitionController@getPractitioners');
Route::get('practitioner/{id}', 'PractitionController@getPractitioner');

Route::get('practitioners', 'PractitionController@getPractitioners');
Route::get('practitioner/{id}', 'PractitionController@getPractitioner');

Route::get('procedure/{patientId}', 'ProcedureController@getProcedures');
Route::get('procedure/{patientId}/{id}', 'ProcedureController@getProcedure');

Route::get('devices/{patientId}', 'DeviceController@getDevices');
Route::get('device/{patientId}/{id}', 'DeviceController@getDevice');

