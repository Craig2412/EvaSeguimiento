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

        $results = $query->execute()->fetchAll('assoc');
        
        $months = range(1, 12); // Genera un array con los números de mes del 1 al 12
        
        $formattedResults = [];
        
        foreach ($months as $month) {
            $formattedResults[] = [
                'month' => $month,
                'total' => 0
            ];
        }
        
        foreach ($results as $result) {
            $formattedResults[$result['month'] - 1] = $result;
        }
        
        //var_dump($formattedResults);
        
        return $formattedResults;
    }
}
