<?php

namespace App\Domain\Charge\Service;

use App\Domain\Charge\Data\ChargeReaderResult;
use App\Domain\Charge\Repository\ChargeRepository;

/**
 * Service.
 */
final class ChargeReader
{
    private ChargeRepository $repository;

    /**
     * The constructor.
     *
     * @param ChargeRepository $repository The repository
     */
    public function __construct(ChargeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a charge.
     *
     * @param int $chargeId The charge id
     *
     * @return ChargeReaderResult The result
     */
    public function getCharge(int $chargeId): ChargeReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $chargeRow = $this->repository->getChargeById($chargeId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new ChargeReaderResult();
        $result->id = $chargeRow['id'];
        $result->charge = $chargeRow['charge'];
        $result->descipcion = $chargeRow['descipcion'];
        $result->created = $chargeRow['created'];
        $result->updated = $chargeRow['updated'];
        
        return $result;
    }
}
