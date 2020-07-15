<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function returnAPIError(\Exception $e)
    {
        if (app()->environment('production')) {
            return response()->json([
                'message' => 'API error:' . $e->getCode(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }

        return response()->json([
            'message' => 'API error:' . $e->getCode() . ' ' . $e->getMessage(),
            Response::HTTP_INTERNAL_SERVER_ERROR
        ]);

    }

}
