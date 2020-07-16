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

Route::get('patients', 'PatientController@getAllPatients');
Route::delete('patient/{id}', 'PatientController@deletePatient');
Route::get('patient/{id}', 'PatientController@getPatient');
Route::post('patient', 'PatientController@createPatient');

Route::get('practitioners', 'PractitionerController@getAllPractitioners');
Route::get('practitioner/{id}', 'PractitionerController@getPractitioner');

Route::get('conditions/{patientId}', 'ConditionController@getAllConditions');
Route::get('condition/{patientId}/{id}', 'ConditionController@getCondition');

Route::get('procedures/{patientId}', 'ProcedureController@getProcedures');
Route::get('procedure/{patientId}/{id}', 'ProcedureController@getProcedure');

Route::get('devices/{patientId}', 'DeviceController@getAllDevices');
Route::get('device/{patientId}/{id}', 'DeviceController@getDevice');

/* Route::group(['namespace' => 'api', 'prefix' => 'commments'], function () {
    Route::get('all', 'CommentController@getAllComments');
}); */
Route::get('comments', 'CommentController@getAllComments');
Route::get('comment/{id}', 'CommentController@getComment');
Route::post('comment', 'CommentController@createComment');
Route::delete('comment/{id}', 'CommentController@deleteComment');

Route::get('epic/patients', 'PatientController@epicPatients');
Route::get('epic/patient/{patientId}', 'PatientController@epicPatient');

Route::get('epic/practitioners', 'PractitionerController@epicAllPractitioners');
Route::get('epic/practitioner/{id}', 'PractitionerController@epicPractitioner');

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

