<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Actions;

use Illuminate\Contracts\Hashing\Hasher;
use Kodeksoff\Confirmatio\Contracts\LimiterContract;
use Kodeksoff\Confirmatio\DataTransferObjects\CreateConfirmationData;
use Kodeksoff\Confirmatio\Exceptions\TooManyAttemptsException;
use Kodeksoff\Confirmatio\Models\Confirmation;
use Throwable;

final readonly class CreateConfirmationAction
{
    public function __construct(private Hasher $hasher, private LimiterContract $limiterContract)
    {
    }

    /** @throws Throwable */
    public function __invoke(CreateConfirmationData $createConfirmationData): Confirmation
    {
        $tooManyAttempts = $this
            ->limiterContract
            ->tooManyAttempts((string)$createConfirmationData->target);

        throw_if(
            $tooManyAttempts,
            new TooManyAttemptsException(),
        );

        $confirmation = new Confirmation();
        $confirmation->target = (string)$createConfirmationData->target;
        $confirmation->secret = $this
            ->hasher
            ->make($createConfirmationData->code);
        $confirmation->attempts = 0;
        $confirmation->confirmed_at = null;
        $confirmation->save();

        $this
            ->limiterContract
            ->hitFor($confirmation);

        return $confirmation;
    }
}
