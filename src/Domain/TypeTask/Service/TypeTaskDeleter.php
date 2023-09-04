<?php

namespace App\Domain\TypeTask\Service;

use App\Domain\TypeTask\Repository\TypeTaskRepository;

final class TypeTaskDeleter
{
    private TypeTaskRepository $repository;

    public function __construct(TypeTaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteTypeTask(int $typeTaskId): void
    {

        $this->repository->deleteTypeTaskById($typeTaskId);
    }
}
