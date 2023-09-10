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
                'COUNT(*) as total'
            ])
            ->leftjoin(['responsibles'=>'responsibles'], 'responsibles.id = tasks.id_responsable')
            ->group('tasks.id_responsable'); 
        $consulta = $query->execute()->fetchAll('assoc');
///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $query2 = $this->queryFactory->newSelect('tasks');
       
        $query2->select(
            [
                'responsibles.direccion',               
                'COUNT(*) as total2'
            ])
            ->leftjoin(['responsibles'=>'responsibles'], 'responsibles.id = tasks.id_responsable')
            ->group('tasks.id_responsable');
        $query2->where(['tasks.id_status' => 3]);
///////////////////////////////////////////////////////////////////////////////////////////////////////////

        $consulta2 = $query2->execute()->fetchAll('assoc');
        $return = [$consulta , $consulta2];

        return $return ?: [];
    }
}
