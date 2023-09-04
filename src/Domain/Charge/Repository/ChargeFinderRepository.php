<?php

namespace App\Domain\Charge\Repository;

use App\Factory\QueryFactory;

final class ChargeFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findCharges(): array
    {
        $query = $this->queryFactory->newSelect('charges');

        $query->select(
            [
                'id',
                'charge'                
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
