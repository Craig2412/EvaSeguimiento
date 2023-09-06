<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskbyStatusFinderItem;
use App\Domain\Task\Data\TaskbyStatusFinderResult;
use App\Domain\Task\Repository\TaskbyStatusFinderRepository;

final class TaskbyStatusFinder
{
    private TaskbyStatusFinderRepository $repository;

    public function __construct(TaskbyStatusFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskbyStatus(): TaskbyStatusFinderResult
    {
        
        // Input validation
        $taskbyStatus = $this->repository->findTaskbyStatus();

        return $this->createResult($taskbyStatus);
    }

    private function createResult(array $taskbyStatusRows): TaskbyStatusFinderResult
    {
        $result = new TaskbyStatusFinderResult();
        
        foreach ($taskbyStatusRows as $taskbyStatusRow) {
            $taskbyStatus = new TaskbyStatusFinderItem();
           
            $taskbyStatus->state = $taskbyStatusRow['state'];
            $taskbyStatus->total = $taskbyStatusRow['total'];
            

            $result->taskbyStatus[] = $taskbyStatus;
        }
        
        return $result;
    }
}
