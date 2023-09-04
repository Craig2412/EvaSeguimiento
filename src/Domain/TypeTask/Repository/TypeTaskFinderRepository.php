<?php

namespace App\Domain\TypeTask\Repository;

use App\Factory\QueryFactory;

final class TypeTaskFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTypeTasks(): array
    {
        $query = $this->queryFactory->newSelect('type_tasks');

        $query->select(
                        [
                            'type_tasks.id',
                            'type_tasks.tipo_tarea',
                            'type_tasks.descripcion',
                            'type_tasks.id_area',
                            'areas.area',
                            'type_tasks.created',
                            'type_tasks.updated'
                        ]
                    )
              ->leftjoin(['areas'=>'areas'], 'areas.id = type_tasks.id_area');

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}