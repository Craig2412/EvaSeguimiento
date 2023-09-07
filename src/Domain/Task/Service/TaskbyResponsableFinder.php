<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskFinderItem;
use App\Domain\Task\Data\TaskFinderResult;
use App\Domain\Task\Repository\TaskbyResponsableFinderRepository;

final class TaskbyResponsableFinder
{
    private TaskbyResponsableFinderRepository $repository;

    public function __construct(TaskbyResponsableFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskbyResponsable($responsableId): TaskFinderResult
    {
        // Input validation
        $taskbyResponsable = $this->repository->findTaskbyResponsable($responsableId);

        return $this->createResult($taskbyResponsable);
    }

    private function createResult(array $taskbyResponsableRows): TaskFinderResult
    {
        $result = new TaskFinderResult();

        foreach ($taskbyResponsableRows as $taskbyResponsableRow) {
            $taskbyResponsable = new TaskFinderItem();
           
            $taskbyResponsable->id = $taskbyResponsableRow['id'];
            $taskbyResponsable->title = $taskbyResponsableRow['title'];
            $taskbyResponsable->description = $taskbyResponsableRow['description'];
            
            $taskbyResponsable->id_status = $taskbyResponsableRow['id_status'];
            $taskbyResponsable->status = $taskbyResponsableRow['state'];
            $taskbyResponsable->id_area = $taskbyResponsableRow['id_area'];
            $taskbyResponsable->area = $taskbyResponsableRow['area'];
            $taskbyResponsable->id_responsable = $taskbyResponsableRow['id_responsable'];
            $taskbyResponsable->nombre = $taskbyResponsableRow['nombre'];
            $taskbyResponsable->direccion = $taskbyResponsableRow['direccion'];
            $taskbyResponsable->id_type_task = $taskbyResponsableRow['id_type_task'];
            $taskbyResponsable->type_task = $taskbyResponsableRow['tipo_tarea'];

            $taskbyResponsable->initial_date = $taskbyResponsableRow['initial_date'];
            $taskbyResponsable->estimated_date = $taskbyResponsableRow['estimated_date'];
            $taskbyResponsable->due_date = $taskbyResponsableRow['due_date'];
            $taskbyResponsable->created = $taskbyResponsableRow['created'];
            $taskbyResponsable->updated = $taskbyResponsableRow['updated'];

            $result->taskbyResponsable[] = $taskbyResponsable;
        }

        return $result;
    }
}
