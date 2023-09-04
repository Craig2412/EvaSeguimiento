<?php

namespace App\Domain\Status\Service;

use App\Domain\Status\Repository\StatusRepository;

final class StatusDeleter
{
    private StatusRepository $repository;

    public function __construct(StatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteStatus(int $statusId): void
    {

        $this->repository->deleteStatusById($statusId);
    }
}
