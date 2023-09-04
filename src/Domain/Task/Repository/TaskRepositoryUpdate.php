<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TaskRepositoryUpdate
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->fecha = date("d-m-Y H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
    }

    public function updateTask(int $taskId, array $task): array
    {
        $row = $this->toRow($task);
        $this->queryFactory->newUpdate('task', $row)
            ->where(['id' => $taskId])
            ->execute();
            return $row;
    }

    public function existsTaskId(int $taskId): bool
    {
        $query = $this->queryFactory->newSelect('task');
        $query->select('id')->where(['id' => $taskId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteTaskById(int $taskId): void
    {
        $this->queryFactory->newDelete('task')
            ->where(['id' => $taskId])
            ->execute();
    }

    private function toRow(array $task): array
    {
        return [
            'id_status' => $task['id_status'],
            'updated' => $this->fecha
        ];
    }
}
