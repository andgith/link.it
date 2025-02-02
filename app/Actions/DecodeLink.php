<?php

namespace App\Actions;

use App\Models\Link;
use Illuminate\Support\Fluent;

class DecodeLink
{
    public function handle(Fluent $attributes): Link
    {
        $link = Link::where('link', $attributes->link)->firstOrFail();

        $link->increment('clicks');

        $link->last_clicked_at = now();

        $link->save();

        return $link;
    }
}
