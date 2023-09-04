<?php

namespace App\Domain\Area\Service;

use App\Domain\Area\Data\AreaFinderItem;
use App\Domain\Area\Data\AreaFinderResult;
use App\Domain\Area\Repository\AreaFinderRepository;

final class AreaFinder
{
    private AreaFinderRepository $repository;

    public function __construct(AreaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findAreas(): AreaFinderResult
    {
        // Input validation
        // ...

        $areas = $this->repository->findAreas();

        return $this->createResult($areas);
    }

    private function createResult(array $areaRows): AreaFinderResult
    {
        $result = new AreaFinderResult();

        foreach ($areaRows as $areaRow) {
            $area = new AreaFinderItem();
            $area->id = $areaRow['id'];
            $area->area = $areaRow['area'];
            $area->descripcion = $areaRow['descripcion'];
            $area->created = $areaRow['created'];
            $area->updated = $areaRow['updated'];

            $result->areas[] = $area;
        }

        return $result;
    }
}
