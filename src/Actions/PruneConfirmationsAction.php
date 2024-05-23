<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio\Actions;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Kodeksoff\Confirmatio\Models\Confirmation;

final readonly class PruneConfirmationsAction
{
    public function __invoke(?DateTimeInterface $before = null, int $chunkSize = 1000): int
    {
        $totalDeletedCount = 0;
        do {
            $deleted = Confirmation::query()
                ->when(
                    $before,
                    static fn (Builder $builder): Builder => $builder->where(
                        'created_at',
                        '<',
                        $before,
                    ),
                )
                ->take($chunkSize)
                ->delete();
            $totalDeletedCount += $deleted;
        } while ($deleted !== 0);

        return $totalDeletedCount;
    }
}
