<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Library\Services\EpicService;
use App\Library\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    /** @var PatientService */
    protected PatientService $patientService;
    protected EpicService $epicService;

    public function __construct(EpicService $epicService, PatientService $patientService)
    {
        $this->epicService = $epicService;
        $this->patientService = $patientService;
        //  $this->epicService = app()->make('App\Library\Services\EpicService');
    }

    public function searchPatients(PatientRequest $request)
//    public function searchPatients(Request $request)
    {
        /*$validatedData = $request->validate([
            '_id' => 'nullable|max:80',
            'identifier' => 'nullable|max:80',
            'family' => 'nullable|max:80',
            'given' => 'nullable|max:80',
            'birthdate' => 'nullable|max:80',
            'gender' => 'nullable|in:female,male,other,unknown',
            'address' => 'nullable|max:80',
            'telecom' => 'nullable|max:80',
        ]);*/

        // http://localhost:8000/api/patients?family=Argonaut&given=Jason
        try {
            //         $patients = $this->epicService->searchPatients($validatedData);
            $patients = $this->epicService->searchPatients($request->all());
            $this->patientService->savePatients($patients);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Patient lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
        return response()->json(iterator_to_array($patients));
    }

    public function createPatient(Request $request)
    {
        // todo
        return response()->json(['test']);
    }

    public function getPatient($patientId)
    {
        $patient = $this->epicService->getPatient($patientId);
        return response()->json($patient);
    }

    public function updatePatient(Request $request, $id)
    {
        // todo
    }

    public function deletePatient($id)
    {
        // todo
    }
}
