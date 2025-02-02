<?php

use App\Services\UniqueKeyGenerator;

beforeEach(function () {
    $this->generator = new UniqueKeyGenerator();
});

test('generates key with no collisions', function () {
    $existingKeys = [];
    $key = $this->generator->generate(
        fn($key) => in_array($key, $existingKeys)
    );

    expect($key)
        ->toBeString()
        ->toHaveLength(6);
});

test('generates key with single collision', function () {
    $attempts = 0;
    $collidingKey = 'abc123';
    
    $key = $this->generator->generate(
        function($key) use ($collidingKey, &$attempts) {
            $attempts++;
            return $key === $collidingKey && $attempts === 1;
        }
    );

    expect($key)
        ->toBeString()
        ->toHaveLength(6)
        ->not->toBe($collidingKey);
    
    expect($attempts)->toBe(1);
});

test('increases length after multiple collisions', function () {
    $attempts = 0;
    
    $key = $this->generator->generate(
        function($key) use (&$attempts) {
            $attempts++;
            return $attempts <= 3; // Force 3 collisions
        }
    );

    expect($key)
        ->toBeString()
        ->toHaveLength(7);
    
    expect($attempts)->toBe(4);
});

test('throws exception when max attempts reached', function () {
    $action = fn() => $this->generator->generate(
        fn($key) => true // Always return true to simulate constant collisions
    );

    expect($action)
        ->toThrow(RuntimeException::class, 'Unable to generate unique key even with maximum length of 12');
}); 