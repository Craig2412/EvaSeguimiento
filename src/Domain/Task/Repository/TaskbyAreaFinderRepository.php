<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;

final class TaskbyAreaFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTaskbyArea(): array
    {
        
        $query = $this->queryFactory->newSelect('tasks');
        $query->select([
            'total' => $query->func()->count('*'),
            'areas.area'
        ])
        ->leftJoin('areas', 'areas.id = tasks.id_area')
        ->group('tasks.id_area');
            
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
