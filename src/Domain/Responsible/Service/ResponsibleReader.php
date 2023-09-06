<?php

namespace App\Domain\Responsible\Service;

use App\Domain\Responsible\Data\ResponsibleReaderResult;
use App\Domain\Responsible\Repository\ResponsibleRepository;

/**
 * Service.
 */
final class ResponsibleReader
{
    private ResponsibleRepository $repository;

    /**
     * The constructor.
     *
     * @param ResponsibleRepository $repository The repository
     */
    public function __construct(ResponsibleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a responsible.
     *
     * @param int $responsibleId The responsible id
     *
     * @return ResponsibleReaderResult The result
     */
    public function getResponsible(int $responsibleId): ResponsibleReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $responsibleRow = $this->repository->getResponsibleById($responsibleId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new ResponsibleReaderResult();
        $result->id = $responsibleRow['id'];
        $result->nombre = $responsibleRow['nombre'];
        $result->direccion = $responsibleRow['direccion'];
        $result->gmail = $responsibleRow['gmail'];
        $result->id_charge = $responsibleRow['id_charge'];
        $result->charge = $responsibleRow['charge'];
        $result->created = $responsibleRow['created'];
        $result->updated = $responsibleRow['charge'];
        
        return $result;
    }
}
