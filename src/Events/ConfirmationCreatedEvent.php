<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Kodeksoff\Confirmatio\Models\Confirmation;

class ConfirmationCreatedEvent
{
    use Dispatchable;

    public function __construct(public readonly Confirmation $confirmation)
    {
    }
}
