<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Logging\CustomLogger;

class ApiController extends Controller
{

    protected $logger;

    public function __construct(CustomLogger $logger)
    {
        $this->logger = $logger;
    }

    public function respond($data, int $status_code = 200)
    {
        return response($data)->setStatusCode($status_code);
    }

    public function respondWithError(string $message = 'Internal error', $status_code = null)
    {
        $response = [
            'data'      => null,
            'status'    => 'error',
            'message'   => $message
        ];

        if (!$status_code) {
            return $this->respond($response, 500);
        } else {
            return $this->respond($response, $status_code);
        }
    }

    public function respondNotFound(string $message = 'Resource not found')
    {
        return $this->respondWithError($message, 404);
    }

}
