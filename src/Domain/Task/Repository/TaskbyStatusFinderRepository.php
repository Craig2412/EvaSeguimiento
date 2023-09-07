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
            'total' => $query->func()->count('*'),
            'status.state'
        ])
        ->leftJoin('status', 'status.id = tasks.id_status')
        ->group('tasks.id_status');

        if ($value === 1) {
            //Se genera la consulta por los tipos de tareas
            $query->where(['tasks.id_type_task' => $busquedaId]);
        }else {
            //Se genera la consulta por direcciones de linea
            $query->where(['tasks.id_area' => $busquedaId]);

        }
       
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
