<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskbyAreaFinderItem;
use App\Domain\Task\Data\TaskbyAreaFinderResult;
use App\Domain\Task\Repository\TaskbyAreaFinderRepository;

final class TaskbyAreaFinder
{
    private TaskbyAreaFinderRepository $repository;

    public function __construct(TaskbyAreaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskbyArea(): TaskbyAreaFinderResult
    {
        
        // Input validation
        $taskbyArea = $this->repository->findTaskbyArea();

        return $this->createResult($taskbyArea);
    }

    private function createResult(array $taskbyAreaRows): TaskbyAreaFinderResult
    {
        $result = new TaskbyAreaFinderResult();
        
        foreach ($taskbyAreaRows as $taskbyAreaRow) {
            $taskbyArea = new TaskbyAreaFinderItem();
           
            $taskbyArea->area = $taskbyAreaRow['area'];
            $taskbyArea->total = $taskbyAreaRow['total'];
            

            $result->taskbyArea[] = $taskbyArea;
        }
        
        return $result;
    }
}
