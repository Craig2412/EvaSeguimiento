<?php

namespace App\Domain\Charge\Service;

use App\Domain\Charge\Data\ChargeFinderItem;
use App\Domain\Charge\Data\ChargeFinderResult;
use App\Domain\Charge\Repository\ChargeFinderRepository;

final class ChargeFinder
{
    private ChargeFinderRepository $repository;

    public function __construct(ChargeFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCharges(): ChargeFinderResult
    {
        // Input validation
        // ...

        $charges = $this->repository->findCharges();

        return $this->createResult($charges);
    }

    private function createResult(array $chargeRows): ChargeFinderResult
    {
        $result = new ChargeFinderResult();

        foreach ($chargeRows as $chargeRow) {
            $charge = new ChargeFinderItem();
            $charge->id = $chargeRow['id'];
            $charge->charge = $chargeRow['charge'];

            $result->charges[] = $charge;
        }

        return $result;
    }
}
