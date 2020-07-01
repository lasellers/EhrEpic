<?php

namespace App\Http\Controllers;

use App\Library\Services\EpicService;
use App\Library\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    /** @var PatientService */
    protected PatientService $patientService;
    protected EpicService $epicService;

    /*  protected function __construct(PatientService $patientService)
      {
          $this->patientService = $patientService;
      }
  */
    public function searchPatients($family, $given = "")
    {
        $this->epicService = app()->make('App\Library\Services\EpicService');
//        try {
            $patients = $this->epicService->searchPatients($family, $given);
       // } catch (\Exception $e) {
       // return response()->json(['message' => 'Patient lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
       // }
        return response()->json($patients);
    }

    public function createPatient(Request $request)
    {
        // todo
        return response()->json(['test']);
    }

    public function getPatient($patientId = "")
    {
        $this->epicService = app()->make('App\Library\Services\EpicService');

        $patient = $this->epicService->getPatient($patientId);
        // $patient = $this->patientService->getPatient($patientId);
        return response()->json($patient);
    }

    public function updatePatient(Request $request, $id)
    {
        // todo
        return response()->json(['test']);
    }

    public function deletePatient($id)
    {
        // todo
        return [$id];
    }
}
