<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Contracts\KeyGeneratorInterface;

class UniqueKeyGenerator implements KeyGeneratorInterface
{
    private const MAX_LENGTH = 12;
    private const INITIAL_LENGTH = 6;
    private const ATTEMPTS_PER_LENGTH = 3;

    public function generate(callable $existenceChecker): string
    {
        $length = self::INITIAL_LENGTH;
        $attempts = 0;

        while ($length <= self::MAX_LENGTH) {
            do {
                $key = Str::random($length);
                $attempts++;

                if ($attempts >= self::ATTEMPTS_PER_LENGTH) {
                    $length++;
                    $attempts = 0;
                    continue 2;
                }
            } while ($existenceChecker($key));

            return $key;
        }

        throw new \RuntimeException("Unable to generate unique key even with maximum length of " . self::MAX_LENGTH);
    }
} 