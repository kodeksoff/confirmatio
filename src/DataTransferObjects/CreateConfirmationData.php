<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\DataTransferObjects;

final readonly class CreateConfirmationData
{
    public function __construct(
        public CreateConfirmationTargetData $target,
        public ConfirmationCodeData $code,
    ) {
    }
}
