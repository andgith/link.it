<?php

namespace App\Contracts;

interface KeyGeneratorInterface
{
    public function generate(callable $existenceChecker): string;
} 