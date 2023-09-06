<?php

namespace App\Domain\Task\Repository;

use App\Factory\QueryFactory;

final class TaskbyResponsableFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTaskbyResponsable($responsableId): array
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

        $query->where(['tasks.id_responsable' => $responsableId]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
