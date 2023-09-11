<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TaskRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;

    }

    public function insertTask(array $task): int
    {
        return (int)$this->queryFactory->newInsert('tasks', $this->toRow($task))
            ->execute()
            ->lastInsertId();
    }

    public function getTaskById(int $taskId): array
    {
        $query = $this->queryFactory->newSelect('tasks');
        $query->select(
            [
                'tasks.id',
                'tasks.title',
                'tasks.description',
                'tasks.id_status',
                'status.state',
                'tasks.id_area',
                'areas.area',
                'tasks.id_responsable',
                'responsibles.nombre',
                'responsibles.direccion',
                'tasks.id_type_task',
                'type_tasks.tipo_tarea',
                'tasks.initial_date',
                'tasks.estimated_date',
                'tasks.due_date',
                'tasks.created',
                'tasks.updated'
            ]
        )  
        ->leftjoin(['status'=>'status'], 'status.id = tasks.id_status')
        ->leftjoin(['areas'=>'areas'], 'areas.id = tasks.id_area')
        ->leftjoin(['type_tasks'=>'type_tasks'], 'type_tasks.id = tasks.id_type_task')
        ->leftjoin(['responsibles'=>'responsibles'], 'responsibles.id = tasks.id_responsable');

        $query->where(['tasks.id' => $taskId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Task not found: %s', $taskId));
        }
        return $row;
    }

    public function updateTask(int $taskId, array $task): void
    {
        $update = $this->fecha;
        $row = $this->toRow($task);
        $this->queryFactory->newUpdate('tasks', $row)
            ->where(['id' => $taskId])
            ->execute();
    }

    public function existsTaskId(int $taskId): bool
    {
        $query = $this->queryFactory->newSelect('tasks');
        $query->select('id')->where(['id' => $taskId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteTaskById(int $taskId): void
    {
        $this->queryFactory->newDelete('tasks')
            ->where(['id' => $taskId])
            ->execute();
    }

    private function toRow(array $task): array
    {
        $updated = isset($update) ? $update : null;
        
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
            'created' => $this->fecha,
            'updated' => $updated
        ];
    }
}
