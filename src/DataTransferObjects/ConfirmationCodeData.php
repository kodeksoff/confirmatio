<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\DataTransferObjects;

use Stringable;

final readonly class ConfirmationCodeData implements Stringable
{
    public function __construct(
        public string $value,
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
