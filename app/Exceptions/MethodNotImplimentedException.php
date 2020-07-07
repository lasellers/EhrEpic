<?php

namespace App\Exceptions;

use Throwable;
use Exception;

class MethodNotImplimentedException extends Exception
{
    public function render($request) {
        return response()->json(['error','EPIC Not Connected'], 501);
    }

    /* public function report(Throwable $exception) {
        if($exception instanceOf MethodNotImplimentedException) {
            logger('EPIC Not Connected']);
        }
    } */

}
