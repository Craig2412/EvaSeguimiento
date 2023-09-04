<?php

namespace App\Domain\Status\Service;

use App\Domain\Status\Data\StatusFinderItem;
use App\Domain\Status\Data\StatusFinderResult;
use App\Domain\Status\Repository\StatusFinderRepository;

final class StatusFinder
{
    private StatusFinderRepository $repository;

    public function __construct(StatusFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findStatuss(): StatusFinderResult
    {
        // Input validation
        // ...

        $statuss = $this->repository->findStatuss();

        return $this->createResult($statuss);
    }

    private function createResult(array $statusRows): StatusFinderResult
    {
        $result = new StatusFinderResult();

        foreach ($statusRows as $statusRow) {
            $status = new StatusFinderItem();
            $status->id = $statusRow['id'];
            $status->status = $statusRow['state'];
            $status->id_area = $statusRow['id_area'];
            

            $result->statuss[] = $status;
        }
        //var_dump($result);

        return $result;
    }
}
