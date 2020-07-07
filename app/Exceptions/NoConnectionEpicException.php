<?php

namespace App\Exceptions;

use Exception;

class NoConnectionEpicException extends Exception
{
    public function render($request) {
        // return response()->view('no_connection_epic', [], 501);
        return response()->json(['error','EPIC Not Connected'], 501);
    }
}
