<?php

namespace App\Domain\Requirements\Service;

use App\Domain\Requirements\Data\RequirementsReaderResult;
use App\Domain\Requirements\Repository\RequirementsRepository;

/**
 * Service.
 */
final class RequirementsReader
{
    private RequirementsRepository $repository;

    /**
     * The constructor.
     *
     * @param RequirementsRepository $repository The repository
     */
    public function __construct(RequirementsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a requirements.
     *
     * @param int $requirementsId The requirements id
     *
     * @return RequirementsReaderResult The result
     */
    public function getRequirements(int $requirementsId): RequirementsReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $requirementsRow = $this->repository->getRequirementsById($requirementsId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RequirementsReaderResult();
            $result->id = $requirementsRow['id'];
            $result->format_appointment = $requirementsRow['format_appointment'];
            $result->name = $requirementsRow['name'];
            $result->surname = $requirementsRow['surname'];
            $result->status = $requirementsRow['status'];
            $result->created = $requirementsRow['created'];
            $result->updated = $requirementsRow['updated'];
            
       // var_dump($result);
        return $result;
    }
}
