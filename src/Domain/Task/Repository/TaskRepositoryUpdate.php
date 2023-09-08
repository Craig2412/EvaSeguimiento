<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TaskRepositoryUpdate
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function updateTask(int $taskId, array $task): array
    {
        $row = $this->toRow($task);
        $row["updated"] = $this->fecha;
        $this->queryFactory->newUpdate('tasks', $row)
            ->where(['id' => $taskId])
            ->execute();
            return $row;
    }

    private function toRow(array $task): array
    {   
        return [
            'title' => strtoupper($task['title']),
            'description' => strtoupper($task['description']),
            'id_status' => $task['id_status'],
            'id_area' => $task['id_area'],
            'id_responsable' => $task['id_responsable'],
            'id_type_task' => $task['id_type_task'],
            'initial_date' => $task['initial_date'],
            'estimated_date' => $task['estimated_date'],
            'due_date' => $task['due_date'],
            'updated' => null
        ];
    }
}
