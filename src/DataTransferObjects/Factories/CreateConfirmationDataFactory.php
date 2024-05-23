<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\DataTransferObjects\Factories;

use Kodeksoff\Confirmatio\Common\PhoneFormatter;
use Kodeksoff\Confirmatio\DataTransferObjects\ConfirmationCodeData;
use Kodeksoff\Confirmatio\DataTransferObjects\CreateConfirmationData;
use Kodeksoff\Confirmatio\DataTransferObjects\CreateConfirmationTargetData;
use Kodeksoff\Confirmatio\Exceptions\InvalidTargerValueException;
use Throwable;

class CreateConfirmationDataFactory
{
    /** @throws Throwable */
    public static function fromInput(string $target, string $code): CreateConfirmationData
    {
        if (filter_var($target, FILTER_VALIDATE_EMAIL)) {
            return new CreateConfirmationData(
                new CreateConfirmationTargetData($target),
                new ConfirmationCodeData($code),
            );
        }

        $target = new PhoneFormatter($target);

        throw_if(
            !$target->isValid(),
            new InvalidTargerValueException(),
        );

        return new CreateConfirmationData(
            new CreateConfirmationTargetData($target),
            new ConfirmationCodeData($code),
        );
    }
}
