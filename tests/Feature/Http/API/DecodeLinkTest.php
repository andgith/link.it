<?php

use function Pest\Laravel\postJson;
use Illuminate\Testing\Fluent\AssertableJson;


it('can decode a short url back to original url', function () {
    $response = postJson('/decode', [
        'link' => 'https://link.test/123456'
    ]);

    $response->assertStatus(200);

    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('url')
    );
});
