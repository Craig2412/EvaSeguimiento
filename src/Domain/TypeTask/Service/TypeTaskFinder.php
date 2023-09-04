<?php

namespace App\Domain\TypeTask\Service;

use App\Domain\TypeTask\Data\TypeTaskFinderItem;
use App\Domain\TypeTask\Data\TypeTaskFinderResult;
use App\Domain\TypeTask\Repository\TypeTaskFinderRepository;

final class TypeTaskFinder
{
    private TypeTaskFinderRepository $repository;

    public function __construct(TypeTaskFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTypeTasks(): TypeTaskFinderResult
    {
        // Input validation
        // ...

        $typeTasks = $this->repository->findTypeTasks();

        return $this->createResult($typeTasks);
    }

    private function createResult(array $typeTaskRows): TypeTaskFinderResult
    {
        $result = new TypeTaskFinderResult();

        foreach ($typeTaskRows as $typeTaskRow) {
            $typeTask = new TypeTaskFinderItem();
            $typeTask->id = $typeTaskRow['id'];
            $typeTask->typeTask = $typeTaskRow['tipo_tarea'];
            $typeTask->descripcion = $typeTaskRow['descripcion'];
            $typeTask->id_area = $typeTaskRow['id_area'];
            $typeTask->area = $typeTaskRow['area'];
            $typeTask->created = $typeTaskRow['created'];
            $typeTask->updated = $typeTaskRow['updated'];

            $result->typeTasks[] = $typeTask;
        }

        return $result;
    }
}
