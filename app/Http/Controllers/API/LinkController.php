<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    public function encode(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function decode(Request $request): JsonResponse
    {
        return response()->json();
    }
}
