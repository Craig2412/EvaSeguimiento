<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskbyResponsableAllFinderItem;
use App\Domain\Task\Data\TaskbyResponsableAllFinderResult;
use App\Domain\Task\Repository\TaskbyResponsableAllFinderRepository;
use App\Domain\Task\Repository\TaskbyResponsableAllFinderRepository2;

final class TaskbyResponsableAllFinder
{
    private TaskbyResponsableAllFinderRepository $repository;

    public function __construct(TaskbyResponsableAllFinderRepository $repository  )
    {
        $this->repository = $repository;        
        //$this->repository2 = $repository2;
    }

    public function findTaskbyResponsableAll(): TaskbyResponsableAllFinderResult
    {
        // Input validation
        $taskbyResponsable = $this->repository->findTaskbyResponsableAll();

        return $this->createResult($taskbyResponsable);
    }

    private function createResult(array $taskbyResponsableRows): TaskbyResponsableAllFinderResult
    {
        $result = new TaskbyResponsableAllFinderResult();
        $finish = $taskbyResponsableRows[1];

        foreach ($taskbyResponsableRows[0] as $taskbyResponsableRow) {
            $taskbyResponsable = new TaskbyResponsableAllFinderItem();
           
            $taskbyResponsable->direccion = $taskbyResponsableRow['direccion'];
            $taskbyResponsable->total = $taskbyResponsableRow['total'];

            for ($i=0; $i < count($finish); $i++) { 
                if ($finish[$i]['direccion'] === $taskbyResponsableRow['direccion']) {
                    $taskbyResponsable->completado = $finish[$i]['total2']; 
                }

            }
                // $taskbyResponsable->completado = $taskbyResponsableRow['completado'];
           
            $result->taskbyResponsable[] = $taskbyResponsable;
        }
        return $result;
    }
}
