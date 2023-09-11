<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;

final class TaskbyResponsableAllFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTaskbyResponsableAll(): array
    {
        $query = $this->queryFactory->newSelect('tasks');
       
        $query->select(
            [
                'responsibles.direccion',               
                'IF(sum(tasks.id) is null, 0,COUNT(*)) as total'
            ])
            ->rightjoin(['responsibles'=>'responsibles'], 'responsibles.id = tasks.id_responsable')
            ->group('responsibles.id'); 
        $consulta = $query->execute()->fetchAll('assoc');
///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $query2 = $this->queryFactory->newSelect('tasks');
       
        $query2->select(
            [
                'responsibles.direccion',               
                'IF(sum(tasks.id) is null, 0,COUNT(*)) as total2'
            ])
            ->rightjoin(['responsibles'=>'responsibles'], 'responsibles.id = tasks.id_responsable')
            ->group('responsibles.id');
        $query2->where(['tasks.id_status' => 3]);
///////////////////////////////////////////////////////////////////////////////////////////////////////////

        $consulta2 = $query2->execute()->fetchAll('assoc');
        $return = [$consulta , $consulta2];

        return $return ?: [];
    }
}
