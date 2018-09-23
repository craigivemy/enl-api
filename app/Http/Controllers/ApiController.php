<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function respond($data)
    {
        return response($data)->setStatusCode(200);
    }

    public function respondWithError(string $message = '', $status_code = null)
    {
        $response = [
            'data'      => null,
            'status'    => 'error',
            'message'   => $message
        ];

        if (!$status_code) {
            return response($response);
        } else {
            return response($response)->setStatusCode($status_code);
        }

        // all methods wrapped in try / catch, if something goes wrong
        // use this - will it override modeNotFound tho?
    }

    public function respondNotFound(string $message = '')
    {
        return $this->respondWithError($message, 404);
    }


}
