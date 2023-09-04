<?php

namespace App\Domain\Area\Service;

use App\Domain\Area\Repository\AreaRepository;

final class AreaDeleter
{
    private AreaRepository $repository;

    public function __construct(AreaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteArea(int $areaId): void
    {

        $this->repository->deleteAreaById($areaId);
    }
}
