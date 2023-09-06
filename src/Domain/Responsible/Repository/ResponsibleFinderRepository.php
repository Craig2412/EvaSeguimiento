<?php

namespace App\Domain\Responsible\Repository;

use App\Factory\QueryFactory;

final class ResponsibleFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findResponsibles(): array
    {
        $query = $this->queryFactory->newSelect('responsibles');

        $query->select(
            [
                'responsibles.id',
                'responsibles.nombre',
                'responsibles.direccion',
                'responsibles.gmail',
                'responsibles.id_charge',
                'charges.charge',
                'responsibles.created',
                'responsibles.updated'
            ]
        )
        
        ->leftjoin(['charges'=>'charges'], 'charges.id = responsibles.id_charge');

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
