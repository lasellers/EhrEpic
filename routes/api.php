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

// php artisan route:list

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('patients', 'PatientController@getAllPatients');
Route::get('patient/{id}', 'PatientController@getPatient');

Route::get('practitioners', 'PractitionerController@getAllPractitioners');
Route::get('practitioner/{id}', 'PractitionerController@getPractitioner');

Route::get('conditions/{patientId}', 'ConditionController@getAllConditions');
Route::get('condition/{patientId}/{id}', 'ConditionController@getCondition');

Route::get('procedure/{patientId}', 'ProcedureController@getAllProcedures');
Route::get('procedure/{patientId}/{id}', 'ProcedureController@getProcedure');

Route::get('devices/{patientId}', 'DeviceController@getAllDevices');
Route::get('device/{patientId}/{id}', 'DeviceController@getDevice');

Route::get('/', function () {
    return ['message'=>'EHR Epic API'];
});

