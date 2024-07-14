<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ErrorService {
    public function errorResponse(string $message, int $status = 400): JsonResponse {
        return response()->json([
            "status" => "error",
            "message" => $message
        ], $status);
    }
}