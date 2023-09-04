<?php

namespace App\Domain\Status\Repository;

use App\Factory\QueryFactory;

final class StatusFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findStatuss(): array
    {
        $query = $this->queryFactory->newSelect('status');

        $query->select(
            [
                'id',
                'state'
                
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
