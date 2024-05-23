<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio;

use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Application;
use Kodeksoff\Confirmatio\Commands\PruneConfirmationsCommand;
use Kodeksoff\Confirmatio\Common\PhoneFormatter;
use Kodeksoff\Confirmatio\Contracts\LimiterContract;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ConfirmatioServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this
            ->app
            ->scoped(
                LimiterContract::class,
                static fn (Application $application) => new ConfirmatioLimiter($application->make(RateLimiter::class)),
            );

        $this
            ->app
            ->when(PhoneFormatter::class)
            ->needs('$country')
            ->giveConfig('confirmatio.phone.country_code');
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('confirmatio')
            ->hasConfigFile()
            ->hasMigration('create_confirmations_table')
            ->hasCommand(PruneConfirmationsCommand::class);
    }
}
