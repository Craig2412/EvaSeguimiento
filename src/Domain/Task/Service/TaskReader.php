<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskReaderResult;
use App\Domain\Task\Repository\TaskRepository;

/**
 * Service.
 */
final class TaskReader
{
    private TaskRepository $repository;

    /**
     * The constructor.
     *
     * @param TaskRepository $repository The repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a task.
     *
     * @param int $taskId The task id
     *
     * @return TaskReaderResult The result
     */
    public function getTask(int $taskId): TaskReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $taskRow = $this->repository->getTaskById($taskId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new TaskReaderResult();
            $result->id = $taskRow['id'];
            $result->title = $taskRow['title'];
            $result->description = $taskRow['description'];
            
            $result->id_status = $taskRow['id_status'];
            $result->status = $taskRow['state'];
            $result->id_area = $taskRow['id_area'];
            $result->area = $taskRow['area'];
            $result->id_responsable = $taskRow['id_responsable'];
            $result->nombre = $taskRow['nombre'];
            $result->direccion = $taskRow['direccion'];
            $result->id_type_task = $taskRow['id_type_task'];
            $result->type_task = $taskRow['tipo_tarea'];

            $result->initial_date = $taskRow['initial_date'];
            $result->estimated_date = $taskRow['estimated_date'];
            $result->due_date = $taskRow['due_date'];
            $result->created = $taskRow['created'];
            $result->updated = $taskRow['updated'];

            
        return $result;
    }
}
