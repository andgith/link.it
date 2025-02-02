<?php

namespace App\Actions;

use App\Models\Link;
use App\Models\Domain;
use Illuminate\Support\Fluent;
use App\Contracts\KeyGeneratorInterface;

class EncodeLink
{
    public function __construct(
        private readonly KeyGeneratorInterface $keyGenerator
    ) {}

    public function handle(Fluent $attributes): Link
    {
        $domain = Domain::where('name', $attributes->domain)->firstOr(function () {
            return Domain::default()->first();
        });

        $key = $this->keyGenerator->generate(fn (string $key) => Link::where('key', $key)->exists());

        return $domain->links()->create([
            'url' => $attributes['url'],
            'key' => $key,
            'link' => "https://{$domain->name}/{$key}"
        ]);
    }
}
