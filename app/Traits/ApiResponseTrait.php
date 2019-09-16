<?php

namespace App\Traits;

trait ApiResponseTrait
{

    public function formatData($data = null, bool $status, string $message = "OK")
    {
        return ['data' => $data, 'status' => $status, 'message' => $message];
    }

    public function custom($data, string $message, bool $status, int $statusCode)
    {
        return response()->json($this->formatData($data, $status, $message), $statusCode);
    }

    public function success($data, $message = "OK")
    {
        return response()->json($this->formatData($data, true, $message), 200);
    }

    public function created($data, $message = "created")
    {
        return response()->json($this->formatData($data, true, $message), 201);
    }

    public function notFound(string $message = 'no found', $data = null)
    {
        return response()->json($this->formatData($data, false, $message), 404);
    }

    public function badRequest(string $message = 'invalid request', $data = null)
    {
        return response()->json($this->formatData($data, false, $message), 400);
    }
}
