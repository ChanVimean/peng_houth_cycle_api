<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Bike Rental API",
 *     version="1.0.0",
 *     description="API documentation for Bike Rental System"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local API Server"
 * )
 *
 * @OA\Server(
 *     url="https://peng-houth-cycle-api.onrender.com",
 *     description="Hosted API Server"
 * )
 */
class SwaggerController extends Controller
{
    //
}
