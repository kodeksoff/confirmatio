<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\DataTransferObjects;

use Propaganistas\LaravelPhone\Exceptions\NumberFormatException;
use Propaganistas\LaravelPhone\PhoneNumber;
use Stringable;

final readonly class CreateConfirmationTargetData implements Stringable
{
    public function __construct(
        public PhoneNumber|string $value,
    ) {
    }

    /** @throws NumberFormatException */
    public function __toString()
    {
        if ($this->value instanceof PhoneNumber) {
            return $this
                ->value
                ->format(config('confirmatio.phone.format'));
        }

        return (string)$this->value;
    }
}
