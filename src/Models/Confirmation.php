<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Kodeksoff\Confirmatio\Common\PhoneFormatter;
use Kodeksoff\Confirmatio\Events\ConfirmationCreatedEvent;

/**
 * @property string $target
 * @property string $secret
 * @property int $attempts
 * @property CarbonImmutable $confirmed_at
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read bool $is_confirmed
 * @property-read string $email
 * @property-read PhoneFormatter $phone
 */
class Confirmation extends Model
{
    use HasUuids;

    protected $dispatchesEvents = [
        'created' => ConfirmationCreatedEvent::class,
    ];

    protected $fillable = [
        'target',
        'secret',
        'attempts',
        'confirmed_at',
    ];

    protected $casts = [
        'secret' => 'hashed',
        'confirmed_at' => 'immutable_datetime',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public function isConfirmed(): Attribute
    {
        return new Attribute(
            fn (): bool => filled($this->confirmed_at),
        );
    }

    public function phone(): Attribute
    {
        return new Attribute(
            fn (): PhoneFormatter => new PhoneFormatter($this->target),
        );
    }

    public function email(): Attribute
    {
        return new Attribute(
            fn (): string => $this->target,
        );
    }
}
