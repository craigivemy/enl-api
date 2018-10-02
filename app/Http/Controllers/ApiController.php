<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Logging\CustomLogger;
use Throwable;

class ApiController extends Controller
{

    protected $logger;

    public function __construct(CustomLogger $logger)
    {
        $this->logger = $logger;
    }

    public function respond($data, int $status_code = 200)
    {
        try {
            // is this relying on it being a resource / collection?
            // if so, probs not good?
            return $data->response()->setStatusCode($status_code);
        } catch (Throwable $t) {
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t]);
            return $this->respondWithError(500);
        }
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
