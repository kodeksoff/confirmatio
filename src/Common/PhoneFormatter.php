<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Common;

use Propaganistas\LaravelPhone\PhoneNumber;

class PhoneFormatter extends PhoneNumber
{
    public function __construct(?string $number, string $country = 'RU')
    {
        parent::__construct($number, $country);
    }
}
