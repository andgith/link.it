<?php

use App\Actions\EncodeLink;
use App\Models\Domain;
use App\Models\Link;
use Illuminate\Support\Fluent;
use App\Contracts\KeyGeneratorInterface;

beforeEach(function () {
    // Create a default domain
    Domain::factory()->create([
        'name' => 'short.test',
        'default' => true
    ]);
});

test('it creates a link with default domain when no domain specified', function () {
    // Arrange
    $keyGenerator = mock(KeyGeneratorInterface::class);
    $keyGenerator->shouldReceive('generate')
        ->once()
        ->andReturn('abc123');

    $action = new EncodeLink($keyGenerator);
    
    // Act
    $link = $action->handle(new Fluent([
        'url' => 'https://example.com'
    ]));

    // Assert
    expect($link)
        ->toBeInstanceOf(Link::class)
        ->and($link->url)->toBe('https://example.com')
        ->and($link->key)->toBe('abc123')
        ->and($link->link)->toBe('https://short.test/abc123')
        ->and($link->domain->default)->toBeTrue();
});

test('it creates a link with specified domain', function () {
    // Arrange
    $customDomain = Domain::factory()->create(['name' => 'custom.test']);
    
    $keyGenerator = mock(KeyGeneratorInterface::class);
    $keyGenerator->shouldReceive('generate')
        ->once()
        ->andReturn('xyz789');

    $action = new EncodeLink($keyGenerator);
    
    // Act
    $link = $action->handle(new Fluent([
        'url' => 'https://example.com',
        'domain' => 'custom.test'
    ]));

    // Assert
    expect($link)
        ->toBeInstanceOf(Link::class)
        ->and($link->url)->toBe('https://example.com')
        ->and($link->key)->toBe('xyz789')
        ->and($link->link)->toBe('https://custom.test/xyz789')
        ->and($link->domain->name)->toBe('custom.test');
}); 