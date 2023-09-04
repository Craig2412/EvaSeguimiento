<?php

namespace App\Domain\Status\Service;

use App\Domain\Status\Data\StatusReaderResult;
use App\Domain\Status\Repository\StatusRepository;

/**
 * Service.
 */
final class StatusReader
{
    private StatusRepository $repository;

    /**
     * The constructor.
     *
     * @param StatusRepository $repository The repository
     */
    public function __construct(StatusRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a status.
     *
     * @param int $statusId The status id
     *
     * @return StatusReaderResult The result
     */
    public function getStatus(int $statusId): StatusReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $statusRow = $this->repository->getStatusById($statusId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new StatusReaderResult();
        $result->id = $statusRow['id'];
        $result->status = $statusRow['state'];
        
        return $result;
    }
}
