<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Actions;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Events\Dispatcher;
use Kodeksoff\Confirmatio\DataTransferObjects\ConfirmationCodeData;
use Kodeksoff\Confirmatio\Events\ConfirmationPassedEvent;
use Kodeksoff\Confirmatio\Exceptions\AlreadyConfirmedException;
use Kodeksoff\Confirmatio\Exceptions\InvalidCodeException;
use Kodeksoff\Confirmatio\Models\Confirmation;
use Throwable;

final readonly class ApproveConfirmationAction
{
    public function __construct(
        private Dispatcher $dispatcher,
        private CarbonImmutable $carbonImmutable,
        private Hasher $hasher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function __invoke(Confirmation $confirmation, ConfirmationCodeData $confirmationCodeData): Confirmation
    {
        throw_if(
            $confirmation->is_confirmed,
            new AlreadyConfirmedException(),
        );

        $confirmation->attempts = $confirmation->attempts + 1;

        $hasherCheck = $this
            ->hasher
            ->check($confirmationCodeData->value, $confirmation->secret);

        throw_if(
            ! $hasherCheck,
            tap(new InvalidCodeException(), fn () => $confirmation->save()),
        );

        $confirmation->confirmed_at = $this
            ->carbonImmutable
            ->now();

        $confirmation->save();

        $this
            ->dispatcher
            ->dispatch(new ConfirmationPassedEvent($confirmation));

        return $confirmation;
    }
}
