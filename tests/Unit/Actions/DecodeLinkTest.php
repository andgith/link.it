<?php

use App\Models\Link;
use App\Actions\DecodeLink;
use Illuminate\Support\Fluent;

test('it retrieves and updates link statistics when decoding', function () {
    $link = Link::factory()->create([
        'clicks' => 5,
        'last_clicked_at' => now()->subDay(),
    ]);

    $decoder = new DecodeLink();
    $attributes = new Fluent(['link' => $link->link]);

    $result = $decoder->handle($attributes);

    expect($result->id)->toBe($link->id)
        ->and($result->clicks)->toBe(6)
        ->and($result->last_clicked_at->timestamp)
            ->toBeGreaterThan($link->last_clicked_at->timestamp);
});

test('it throws an exception when link is not found', function () {
    // Arrange
    $decoder = new DecodeLink();
    $attributes = new Fluent(['link' => 'non-existent-link']);

    // Act & Assert
    expect(fn () => $decoder->handle($attributes))
        ->toThrow(Illuminate\Database\Eloquent\ModelNotFoundException::class);
}); 