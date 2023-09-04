<?php

namespace App\Domain\TypeTask\Service;

use App\Domain\TypeTask\Data\TypeTaskXAreaFinderItem;
use App\Domain\TypeTask\Data\TypeTaskXAreaFinderResult;
use App\Domain\TypeTask\Repository\TypeTaskXAreaFinderRepository;

final class TypeTaskXAreaFinder
{
    private TypeTaskXAreaFinderRepository $repository;

    public function __construct(TypeTaskXAreaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTypeTaskXAreas(int $typeTaskXAreaId): TypeTaskXAreaFinderResult
    {
        // Input validation

        $typeTaskXAreas = $this->repository->findTypeTaskXAreas($typeTaskXAreaId);

        return $this->createResult($typeTaskXAreas);
    }

    private function createResult(array $typeTaskXAreaRows): TypeTaskXAreaFinderResult
    {
        $result = new TypeTaskXAreaFinderResult();

        foreach ($typeTaskXAreaRows as $typeTaskXAreaRow) {
            $typeTaskXArea = new TypeTaskXAreaFinderItem();
            $typeTaskXArea->id = $typeTaskXAreaRow['id'];
            $typeTaskXArea->typeTaskXArea = $typeTaskXAreaRow['tipo_tarea'];
            $typeTaskXArea->descripcion = $typeTaskXAreaRow['descripcion'];
            $typeTaskXArea->id_area = $typeTaskXAreaRow['id_area'];
            $typeTaskXArea->area = $typeTaskXAreaRow['area'];
            $typeTaskXArea->created = $typeTaskXAreaRow['created'];
            $typeTaskXArea->updated = $typeTaskXAreaRow['updated'];

            $result->typeTaskXAreas[] = $typeTaskXArea;
        }

        return $result;
    }
}
