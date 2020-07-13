<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Library\Services\EpicService;
use App\Library\Services\PatientService;
use App\Models\Comment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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

    public function getAllPatients(Request $request)
    {
        try {
            return response()->json(Patient::all()->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Patient lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getPatient($id)
    {
        try {
            return response()->json(Patient::find($id)->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Patient lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function createPatient(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'practitionerId' => 'required|max:80',
            'patientId' => 'required|max:80',
            'given' => 'required|min:1',
            'family' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $messages = [];
            foreach ($validator->errors()->getMessages() as $item) {
                array_push($messages, $item);
            }
            return response()->json([
                'errors' => $messages,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'request' => $data
            ]);
        }

        try {
            $patient = Patient::create($data);
            $patient->json=json_encode($patient->toArray());
            $patient->save();
            return $patient->toArray();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Patient create ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function deletePatient($id)
    {
        try {
            $result = Patient::find($id)->delete();
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Patient lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function updatePatient(Request $request, $id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function noEpic()
    {
        throw new \App\Exceptions\NoConnectionEpicException();
    }

    public function searchPatient($patientId)
    {
        $patient = $this->epicService->getPatient($patientId);
        return response()->json($patient);
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
}
