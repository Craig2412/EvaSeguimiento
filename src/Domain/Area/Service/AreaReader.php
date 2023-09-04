<?php

namespace App\Domain\Area\Service;

use App\Domain\Area\Data\AreaReaderResult;
use App\Domain\Area\Repository\AreaRepository;

/**
 * Service.
 */
final class AreaReader
{
    private AreaRepository $repository;

    /**
     * The constructor.
     *
     * @param AreaRepository $repository The repository
     */
    public function __construct(AreaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a area.
     *
     * @param int $areaId The area id
     *
     * @return AreaReaderResult The result
     */
    public function getArea(int $areaId): AreaReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $areaRow = $this->repository->getAreaById($areaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new AreaReaderResult();
        $result->id = $areaRow['id'];
        $result->area = $areaRow['area'];
        $result->descipcion = $areaRow['descipcion'];
        $result->created = $areaRow['created'];
        $result->updated = $areaRow['updated'];
        
        return $result;
    }
}
