<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PractitionerController extends Controller
{

    public function getAllPractitioners(Request $request)
    {
        try {
            return response()->json(Practitioner::all()->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Practitioner lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getPractitioner($id)
    {
        try {
            return response()->json(Practitioner::find($id)->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Practitioner lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function createPractitioner(Request $request)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function updatePractitioner(Request $request, $id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function deletePractitioner($id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function epicAllPractitioners(Request $request)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

    public function epicGetPractitioner($id)
    {
        throw new \App\Exceptions\MethodNotImplimentedException();
    }

}
