<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kodeksoff\Confirmatio\Confirmatio
 */
final class Confirmatio extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kodeksoff\Confirmatio\Confirmatio::class;
    }
}
