<?php

namespace App\Domain\Responsible\Service;

use App\Domain\Responsible\Repository\ResponsibleRepository;

final class ResponsibleDeleter
{
    private ResponsibleRepository $repository;

    public function __construct(ResponsibleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteResponsible(int $ResponsibleId): void
    {

        $this->repository->deleteResponsibleById($ResponsibleId);
    }
}
