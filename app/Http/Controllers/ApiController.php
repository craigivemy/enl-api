<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function respond($data, int $status_code = 200)
    {
        return response($data)->setStatusCode($status_code);
    }

    public function respondWithError(string $prettyMessage = '', $status_code = null)
    {
        $response = [
            'data'      => null,
            'status'    => 'error',
            'message'   => $prettyMessage
        ];

        if (!$status_code) {
            return $this->respond($response, 500);
        } else {
            return $this->respond($response, $status_code);
        }
    }

    public function respondNotFound(string $message = '')
    {
        return $this->respondWithError($message, 404);
    }

}
