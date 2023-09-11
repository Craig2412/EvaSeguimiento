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

    public function findTaskbyStatus(int $busquedaId, int $value): array
    {
        
        $query = $this->queryFactory->newSelect('tasks');
        $query->select([
            'tasks.id_status',
            'total' => $query->func()->count('*')
        ]);

        if ($value === 1) {
            //Se genera la consulta por los tipos de tareas
            $query->where(['tasks.id_type_task' => $busquedaId]);
        }else {
            //Se genera la consulta por direcciones de linea
            $query->where(['tasks.id_area' => $busquedaId]);

        }
        $query->group('tasks.id_status');


        $results = $query->execute()->fetchAll('assoc');
        
        $statuss = range(1, 4); 
        
        $formattedResults = [];
        
        foreach ($statuss as $status) {
            $formattedResults[] = [
                'id_status' => $status,
                'total' => 0
            ];
        }
        
        foreach ($results as $result) {
            $formattedResults[$result['id_status'] - 1] = $result;
        }
        return $formattedResults ?: [];
    }
}
