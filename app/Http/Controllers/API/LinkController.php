<?php

namespace App\Http\Controllers\API;

use App\Actions\DecodeLink;
use App\Actions\EncodeLink;
use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Http\Requests\DecodeLinkRequest;
use App\Http\Requests\EncodeLinkRequest;

class LinkController extends Controller
{
    public function encode(EncodeLinkRequest $request, EncodeLink $action): LinkResource
    {
        $link = $action->handle($request->fluent());

        return LinkResource::make($link);
    }

    public function decode(DecodeLinkRequest $request, DecodeLink $action): LinkResource
    {
        return LinkResource::make(
            $action->handle($request->fluent())
        );
    }
}
