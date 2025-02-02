<?php

use function Pest\Laravel\postJson;
use Illuminate\Testing\Fluent\AssertableJson;


it('can encode a long url to short url', function () {
    $longUrl = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';

    $response = postJson('/encode', [
        'url' => $longUrl
    ]);

    $response->assertStatus(200);

    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('link')
    );
});
