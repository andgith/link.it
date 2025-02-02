<?php

use App\Models\Link;
use function Pest\Laravel\postJson;
use Illuminate\Testing\Fluent\AssertableJson;

it('can decode a short url back to original url', function () {
    $link = Link::factory()->create();
    
    $response = postJson('/decode', [
        'link' => $link->link
    ]);

    $response->assertStatus(200);

    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('data.link')
            ->has('data.url')
            ->has('data.expires_at')
    );
});


it('it validates link', function () {
    $link = Link::factory()->create();
    
    $response = postJson('/decode', [
        'link' => 'non-existent-link'
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['link']);
});
