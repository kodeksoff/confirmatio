<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio;

use Illuminate\Cache\RateLimiter;
use Kodeksoff\Confirmatio\Contracts\LimiterContract;
use Kodeksoff\Confirmatio\Models\Confirmation;

readonly class ConfirmatioLimiter implements LimiterContract
{
    public function __construct(private RateLimiter $rateLimiter)
    {
    }

    public function limiterInstance(): RateLimiter
    {
        return $this->rateLimiter;
    }

    public function availableIn(string|int $key): int
    {
        return $this
            ->rateLimiter
            ->availableIn("confirmation_attempts_$key");
    }

    public function tooManyAttemptsFor(Confirmation $confirmation, int $maxAttempts = 1): bool
    {
        return $this->tooManyAttempts($confirmation->target, $maxAttempts);
    }

    public function tooManyAttempts(string|int $key, int $maxAttempts = 1): bool
    {
        return $this
            ->rateLimiter
            ->tooManyAttempts(
                "confirmation_attempts_$key",
                $maxAttempts,
            );
    }

    public function hitFor(Confirmation $confirmation, int $delaySeconds = 60): void
    {
        $this->hit($confirmation->target, $delaySeconds);
    }

    public function hit(string|int $key, int $delaySeconds = 60): void
    {
        $this
            ->rateLimiter
            ->hit("confirmation_attempts_$key", $delaySeconds);
    }
}
