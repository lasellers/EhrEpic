<?php

namespace App\Http\Controllers;

use App\Library\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function getAllPatients(PatientService $patientService)
    {
        // todo
        $patients = $patientService->getPatients();
        return response()->json($patients);
    }

    public function createPatient(Request $request)
    {
        // todo
        return response()->json(['test']);
    }

    public function getPatient($id)
    {
        // todo
        return response()->json(['test']);
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
