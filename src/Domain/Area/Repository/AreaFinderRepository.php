<?php

namespace App\Domain\Area\Repository;

use App\Factory\QueryFactory;

final class AreaFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findAreas(): array
    {
        $query = $this->queryFactory->newSelect('areas');

        $query->select(
            [
                'id',
                'area',
                'descripcion',
                'created',
                'updated'
                
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
