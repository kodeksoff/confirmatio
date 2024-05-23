<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Commands;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Kodeksoff\Confirmatio\Actions\PruneConfirmationsAction;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Throwable;

#[AsCommand(name: 'confirmations:prune')]
class PruneConfirmationsCommand extends Command
{
    protected $signature = 'confirmations:prune {--hours=24 : The number of hours to retain data}';

    protected $description = 'Prune stale entries from the Confirmations database';

    public function __construct(
        private readonly PruneConfirmationsAction $pruneConfirmationsAction,
        private readonly CarbonImmutable $carbonImmutable,
    ) {
        parent::__construct();
    }

    /** @throws Throwable */
    public function handle(): void
    {
        $hours = $this->option('hours');

        throw_if(
            !is_numeric($hours),
            InvalidArgumentException::class,
        );

        $this->info('Starting prune confirmations...');

        $this->info(
            sprintf(
                'Total deleted: %s',
                ($this->pruneConfirmationsAction)(
                    $this
                        ->carbonImmutable
                        ->now()
                        ->subHours((int)$hours),
                ),
            ),
        );
    }
}
