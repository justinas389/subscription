<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Controller
{
    protected function successResource(JsonResource $resource, int $status = 200): JsonResponse
    {
        return $resource->response()->setStatusCode($status);
    }
    
    protected function successResponse($data = null, int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }
}
