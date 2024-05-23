<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kodeksoff\Confirmatio\ConfirmatioServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Kodeksoff\\Confirmatio\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConfirmatioServiceProvider::class,
        ];
    }
}
