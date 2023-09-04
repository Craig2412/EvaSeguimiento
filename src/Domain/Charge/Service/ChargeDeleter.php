<?php

namespace App\Domain\Charge\Service;

use App\Domain\Charge\Repository\ChargeRepository;

final class ChargeDeleter
{
    private ChargeRepository $repository;

    public function __construct(ChargeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteCharge(int $chargeId): void
    {

        $this->repository->deleteChargeById($chargeId);
    }
}
