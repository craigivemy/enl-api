<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Logging\CustomLogger;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class ApiController extends Controller
{

    protected $logger;

    public function __construct(CustomLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Return formatted API response
     *
     * @param $data
     * @param int $status_code
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function respond($data, int $status_code = 200)
    {
        try {
            if ($data instanceof JsonResource) {
                return $data->response()->setStatusCode($status_code);
            } else {
                return response($data)->setStatusCode($status_code);
            }
        } catch (Throwable $t) {
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t]);
            return $this->respondWithError(500);
        }
    }

    /**
     * Respond with error
     *
     * @param string $message
     * @param null $status_code
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
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

    /**
     * Respond not found
     *
     * @param string $message
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function respondNotFound(string $message = 'Resource not found')
    {
        return $this->respondWithError($message, 404);
    }

    public function respondCreated($resource)
    {
        $response = [
            'data'      => $resource,
            'status'    => 'success'
        ];
        return $this->respond($response, 201);
    }

}
