<?php

namespace App\Domain\Requirements\Repository;

use App\Factory\QueryFactory;

final class RequirementsFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findRequirements($nro_pag,$where,$cant_registros): array
    {
        //Paginador
        $limit = $cant_registros;
        $offset = ($nro_pag - 1) * $limit;
        $query = $this->queryFactory->newSelect('requirements');
        //Fin Paginador
        
        $query->select(
            [
                'requirements.id',
                'format_appointment.format_appointment',
                'users.name',
                'users.surname',
                'state.status',
                'requirements.created',
                'requirements.updated'
            ]
        )

        ->leftjoin(['format_appointment'=>'format_appointments'], 'format_appointment.id = requirements.id_format_appointment')
        ->leftjoin(['users'=>'users'], 'users.id = requirements.id_worker')
        ->leftjoin(['state'=>'status'], 'state.id = requirements.id_status');

        //Paginador
        if (!empty($where)) {
         $query->where($where);    
        }
        
        $query->offset([$offset]);
        $query->limit([$limit]);
        //Fin paginador


        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
