<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;

final class TaskbyStatusFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTaskbyStatus(int $type_taskId): array
    {
        
        $query = $this->queryFactory->newSelect('tasks');
        $query->select([
            'total' => $query->func()->count('*'),
            'status.state'
        ])
        ->leftJoin('status', 'status.id = tasks.id_status')
        ->group('tasks.id_status');
       
        $query->where(['tasks.id_type_task' => $type_taskId]);
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
