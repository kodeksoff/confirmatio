<?php

namespace Kodeksoff\Confirmatio\Common;

use Propaganistas\LaravelPhone\PhoneNumber;

class PhoneFormatter extends PhoneNumber
{
    public function __construct(?string $number, $country = [])
    {
        parent::__construct($number, $country);
    }
}
