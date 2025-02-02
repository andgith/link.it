<?php

namespace App\Http\Controllers\API;

use App\Actions\EncodeLink;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DecodeLinkRequest;
use App\Http\Requests\EncodeLinkRequest;
use App\Http\Resources\LinkResource;

class LinkController extends Controller
{
    public function encode(EncodeLinkRequest $request, EncodeLink $action): LinkResource
    {
        $link = $action->handle($request->fluent());

        return LinkResource::make($link);
    }

    public function decode(Request $request): JsonResponse
    {
        return response()->json();
    }
}
