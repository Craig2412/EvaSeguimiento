<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;


final class TaskbyMonthFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTaskbyMonth(int $year): array
    {
        
        $query = $this->queryFactory->newSelect('tasks');
        $query->select([
            'MONTH(tasks.due_date) AS month',
            'COUNT(tasks.id) AS total'
        ])
        ->where(['YEAR(tasks.due_date)' => $year])
        ->group(['month']);

    return $query->execute()->fetchAll('assoc') ?: [];
    }
}
