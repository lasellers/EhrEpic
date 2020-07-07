<?php

namespace App\Http\Controllers;

use App\Library\Services\EpicService;
use App\Library\Services\PatientService;
use Illuminate\Http\Request;

// Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB
class ProcedureController extends Controller
{
    protected EpicService $epicService;

    public function __construct(EpicService $epicService)
    {
        $this->epicService = $epicService;
    }

    public function getProcedures(string $patientId )
    {
//        $this->epicService = app()->make('App\Library\Services\EpicService');

        $procedure = $this->epicService->getProcedures($patientId);
        // $patient = $this->patientService->getPatient($patientId);
        return response()->json($procedure);

    }

    public function createProcedure(Request $request)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function getProcedure(string $patientId, string $procedureId)
    {
//        $this->epicService = app()->make('App\Library\Services\EpicService');

        $procedure = $this->epicService->getProcedure($patientId, $procedureId);
        // $patient = $this->patientService->getPatient($patientId);
        return response()->json($procedure);
    }

    public function updateProcedure(Request $request, $id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function deleteProcedure($id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }
}
