<?php

declare(strict_types=1);

namespace Kodeksoff\Confirmatio;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Kodeksoff\Confirmatio\Actions\ApproveConfirmationAction;
use Kodeksoff\Confirmatio\Actions\CreateConfirmationAction;
use Kodeksoff\Confirmatio\DataTransferObjects\ConfirmationCodeData;
use Kodeksoff\Confirmatio\DataTransferObjects\Factories\CreateConfirmationDataFactory;
use Kodeksoff\Confirmatio\Models\Confirmation;
use Throwable;

readonly class Confirmatio
{
    public function __construct(
        private Request $request,
        private CreateConfirmationAction $createConfirmationAction,
        private ApproveConfirmationAction $approveConfirmationAction,
        private ConfirmatioLimiter $confirmatioLimiter,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function approve(string $code, ?string $id = null): Confirmation
    {
        return ($this->approveConfirmationAction)(
            $this->findConfirmation($id),
            new ConfirmationCodeData($code),
        );
    }

    /**
     * @throws Throwable
     */
    public function make(string $target, string $code): Confirmation
    {
        return ($this->createConfirmationAction)(
            CreateConfirmationDataFactory::fromInput($target, $code),
        );
    }

    /**
     * @throws Throwable
     */
    public function availableIn(?string $id = null): int
    {
        return $this
            ->confirmatioLimiter
            ->availableIn(
                $this
                    ->findConfirmation($id)
                    ->target,
            );
    }

    /**
     * @throws Throwable
     */
    protected function findConfirmation(?string $id = null): Confirmation
    {
        $confirmation = null;

        if ($id) {
            $confirmation = Confirmation::query()->findOrFail($id);
        }

        if (! $id) {
            $confirmation = $this
                ->request
                ->route('confirmation');
        }

        throw_if(! $confirmation, new ModelNotFoundException());

        return $confirmation;
    }
}
