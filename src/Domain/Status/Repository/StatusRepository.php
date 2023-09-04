<?php

namespace App\Domain\Status\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class StatusRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertStatus(array $status): int
    {
        return (int)$this->queryFactory->newInsert('status', $this->toRow($status))
        ->execute()
        ->lastInsertId();
    }
    
    public function getStatusById(int $statusId): array
    {
        $query = $this->queryFactory->newSelect('status');
        $query->select(
            [
                'id',
                'state'
                ]
            );
            
            $query->where(['id' => $statusId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Status not found: %s', $statusId));
        }
        
        return $row;
    }
    
    public function updateStatus(int $statusId, array $status): array
    {
        $row = $this->toRow($status);
        
        $this->queryFactory->newUpdate('status', $row)
        ->where(['id' => $statusId])
        ->execute();

        return $row;

    }

    public function existsStatusId(int $statusId): bool
    {
        $query = $this->queryFactory->newSelect('status');
        $query->select('id')->where(['id' => $statusId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteStatusById(int $statusId): void
    {
        $this->queryFactory->newDelete('status')
        ->where(['id' => $statusId])
        ->execute();
    }

    private function toRow(array $status): array
    {
        
        $updated = isset($status['updated']) ? $status['updated'] : null;
        
        return [
            'state' => strtoupper($status['state'])
        ];
    }
}
