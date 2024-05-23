<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Contracts;

use Illuminate\Cache\RateLimiter;
use Kodeksoff\Confirmatio\Models\Confirmation;

interface LimiterContract
{
    public function limiterInstance(): RateLimiter;

    public function availableIn(string|int $key): int;

    public function tooManyAttemptsFor(Confirmation $confirmation, int $maxAttempts = 1): bool;

    public function tooManyAttempts(string|int $key, int $maxAttempts = 1): bool;

    public function hitFor(Confirmation $confirmation, int $delaySeconds = 60): void;

    public function hit(string|int $key, int $delaySeconds = 60): void;
}
