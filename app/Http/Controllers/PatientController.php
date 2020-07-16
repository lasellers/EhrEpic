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
            return Patient::all(); // Route automatically converts to json array
            // return response()->json(Patient::all()->toArray());
        } catch (\Exception $e) {
            return $this->returnAPIError($e);
        }
    }

    public function getPatient($id)
    {
        try {
            return Patient::with(['devices', 'procedures', 'conditions'])->find($id);
            // return response()->json(Patient::with(['devices', 'procedures', 'conditions'])->find($id)->toArray());
        } catch (\Exception $e) {
            return $this->returnAPIError($e);
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
            $patient->json = json_encode($patient->toArray());
            $patient->save();
            return $patient;
        } catch (\Exception $e) {
            return $this->returnAPIError($e);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePatient($id)
    {
        try {
            $result = Patient::find($id)->delete();
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return $this->returnAPIError($e);
        }
    }

    public function updatePatient(Request $request, $id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    /**
     * This is a call to EPIC
     *
     * -- TODO make this merge into the new patient tables
     *
     * @param $patientId
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function epicPatient(string $patientId)
    {
        return $this->epicService->getPatient($patientId);
        //$patient = $this->epicService->getPatient($patientId);
        //return response()->json($patient);
    }

    /**
     * This is a call to EPIC
     *
     * -- TODO make this merge into the new patient tables
     *
     * @param PatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function epicPatients(PatientRequest $request)
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
            return $this->returnAPIError($e);
        }
        return response()->json(iterator_to_array($patients));
    }
}
