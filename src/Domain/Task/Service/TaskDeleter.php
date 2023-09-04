<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Repository\TaskRepository;

final class TaskDeleter
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteTask(int $taskId): void
    {
        $this->repository->deleteTaskById($taskId);
    }
}
