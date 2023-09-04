<?php

namespace App\Domain\Area\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class AreaRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertArea(array $area): int
    {
        return (int)$this->queryFactory->newInsert('areas', $this->toRow($area))
        ->execute()
        ->lastInsertId();
    }
    
    public function getAreaById(int $areaId): array
    {
        $query = $this->queryFactory->newSelect('areas');
        $query->select(
            [
                'id',
                'area',
                'descripcion',
                'updated',
                'created'
                ]
            );
            
            $query->where(['id' => $areaId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Area not found: %s', $areaId));
        }
        
        return $row;
    }
    
    public function updateArea(int $areaId, array $area): array
    {
        $row = $this->toRow($area);
        
        $this->queryFactory->newUpdate('areas', $row)
        ->where(['id' => $areaId])
        ->execute();

        return $row;

    }

    public function existsAreaId(int $areaId): bool
    {
        $query = $this->queryFactory->newSelect('areas');
        $query->select('id')->where(['id' => $areaId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteAreaById(int $areaId): void
    {
        $this->queryFactory->newDelete('areas')
        ->where(['id' => $areaId])
        ->execute();
    }

    private function toRow(array $area): array
    {
        
        $updated = isset($area['updated']) ? $area['updated'] : null;
        
        return [
            'area' => strtoupper($area['area']),
            'descripcion' => $area['descripcion'],
            'created' => $this->fecha,
            'updated' => $updated
            
        ];
    }
}
