<?php

use App\Models\Domain;
use function Pest\Laravel\postJson;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('can encode a long url to short url', function () {
    $longUrl = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';

    $response = postJson('/encode', [
        'url' => $longUrl
    ]);

    $response->assertStatus(201);

    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('data.link')
            ->has('data.url')
            ->has('data.expires_at')
    );
});

it('generates link using default domain', function () {
    $longUrl = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';

    $response = postJson('/encode', [
        'url' => $longUrl
    ]);

    $response->assertStatus(201);

    expect($response->json('data.link'))->toContain(Domain::default()->first()->name);
});

it('generates link using specified domain', function () {
    $longUrl = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';

    // Additional domain
    $domain = Domain::factory()->create();

    $response = postJson('/encode', [
        'url' => $longUrl,
        'domain' => $domain->name
    ]);

    $response->assertStatus(201);

    expect($response->json('data.link'))->toContain($domain->name);
});

it('it validates domain', function () {
    $longUrl = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';

    $response = postJson('/encode', [
        'url' => $longUrl,
        'domain' => 'nonexistent.com'
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['domain']);
});

it('it validates url', function () {
    $response = postJson('/encode', [
        'url' => 'invalid-url'
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['url']);
});
