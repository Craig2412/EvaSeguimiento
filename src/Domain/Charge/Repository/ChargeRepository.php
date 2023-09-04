<?php

namespace App\Domain\Charge\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class ChargeRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertCharge(array $charge): int
    {
        return (int)$this->queryFactory->newInsert('charges', $this->toRow($charge))
        ->execute()
        ->lastInsertId();
    }
    
    public function getChargeById(int $chargeId): array
    {
        $query = $this->queryFactory->newSelect('charges');
        $query->select(
            [
                'id',
                'charge'
                ]
            );
            
            $query->where(['id' => $chargeId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Charge not found: %s', $chargeId));
        }
        
        return $row;
    }
    
    public function updateCharge(int $chargeId, array $charge): array
    {
        $row = $this->toRow($charge);
        
        $this->queryFactory->newUpdate('charges', $row)
        ->where(['id' => $chargeId])
        ->execute();

        return $row;

    }

    public function existsChargeId(int $chargeId): bool
    {
        $query = $this->queryFactory->newSelect('charges');
        $query->select('id')->where(['id' => $chargeId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteChargeById(int $chargeId): void
    {
        $this->queryFactory->newDelete('charges')
        ->where(['id' => $chargeId])
        ->execute();
    }

    private function toRow(array $charge): array
    {
        
        $updated = isset($charge['updated']) ? $charge['updated'] : null;
        
        return [
            'charge' => strtoupper($charge['charge'])
        ];
    }
}
