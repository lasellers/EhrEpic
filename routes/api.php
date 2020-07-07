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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['namespace' => 'api', 'prefix' => 'commments'], function () {
    Route::get('all', 'CommentController@getAllComments');
});

Route::get('patients', 'PatientController@searchPatients');
Route::get('patient/{id}/delete', 'PatientController@deletePatient');
Route::get('patient/{id}', 'PatientController@getPatient');

Route::get('practitioners', 'PractitionerController@getAllPractitioners');
Route::get('practitioner/{id}', 'PractitionerController@getPractitioner');

Route::get('conditions/{patientId}', 'ConditionController@getAllConditions');
Route::get('condition/{patientId}/{id}', 'ConditionController@getCondition');

Route::get('procedures/{patientId}', 'ProcedureController@getProcedures');
Route::get('procedure/{patientId}/{id}', 'ProcedureController@getProcedure');

Route::get('devices/{patientId}', 'DeviceController@getAllDevices');
Route::get('device/{patientId}/{id}', 'DeviceController@getDevice');

Route::get('/', function () {
    return [
        'patients' => '',
        'patient/{id}' => '',
        'practitioners/{id}' => '',
        'practitioner/{id}' => '',
        'procedures/{patientId}' => '',
        'procedure/{patientId}/{id}' => '',
        'devices/{patientId}' => '',
        'devices/{patientId}/{id}' => '',
    ];
})->name('api');

Route::get('no_epic', 'PatientController@noEpic');

