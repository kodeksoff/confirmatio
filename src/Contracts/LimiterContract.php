<?php

namespace Kodeksoff\Confirmatio\Contracts;

use Illuminate\Cache\RateLimiter;
use Kodeksoff\Confirmatio\Models\Confirmation;

interface LimiterContract
{
    public function limiterInstance(): RateLimiter;

    public function tooManyAttemptsFor(Confirmation $confirmation, int $maxAttempts = 1): bool;

    public function tooManyAttempts($key, int $maxAttempts = 1): bool;

    public function hitFor(Confirmation $confirmation, int $delaySeconds = 60): void;

    public function hit($key, int $delaySeconds = 60): void;
}
