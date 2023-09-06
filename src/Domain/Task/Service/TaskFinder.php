<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskFinderItem;
use App\Domain\Task\Data\TaskFinderResult;
use App\Domain\Task\Repository\TaskFinderRepository;

final class TaskFinder
{
    private TaskFinderRepository $repository;

    public function __construct(TaskFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTask($nro_pag,$where,$cant_registros): TaskFinderResult
    {
        // Input validation
        $task = $this->repository->findTask($nro_pag,$where,$cant_registros);

        return $this->createResult($task);
    }

    private function createResult(array $taskRows): TaskFinderResult
    {
        $result = new TaskFinderResult();

        foreach ($taskRows as $taskRow) {
            $task = new TaskFinderItem();
            
            $task->id = $taskRow['id'];
            $task->title = $taskRow['title'];
            $task->description = $taskRow['description'];
            
            $task->id_status = $taskRow['id_status'];
            $task->status = $taskRow['state'];
            $task->id_area = $taskRow['id_area'];
            $task->area = $taskRow['area'];
            $task->id_responsable = $taskRow['id_responsable'];
            $task->nombre = $taskRow['nombre'];
            $task->direccion = $taskRow['direccion'];
            $task->id_type_task = $taskRow['id_type_task'];
            $task->type_task = $taskRow['tipo_tarea'];

            $task->initial_date = $taskRow['initial_date'];
            $task->estimated_date = $taskRow['estimated_date'];
            $task->due_date = $taskRow['due_date'];
            $task->created = $taskRow['created'];
            $task->updated = $taskRow['updated'];
            

            $result->task[] = $task;
        }
        
        return $result;
    }
}
