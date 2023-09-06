<?php

namespace App\Domain\Responsible\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class ResponsibleRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertResponsible(array $responsible): int
    {
        return (int)$this->queryFactory->newInsert('responsibles', $this->toRow($responsible))
        ->execute()
        ->lastInsertId();
    }
    
    public function getResponsibleById(int $responsibleId): array
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
            
            $query->where(['responsibles.id' => $responsibleId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Responsible not found: %s', $responsibleId));
        }
        
        return $row;
    }
    
    public function updateResponsible(int $responsibleId, array $responsible): array
    {
        $row = $this->toRowUpdate($responsible);
        $row["updated"] = $this->fecha; 
        
        $this->queryFactory->newUpdate('responsibles', $row)
        ->where(['id' => $responsibleId])
        ->execute();

        return $row;

    }

    public function existsResponsibleId(int $responsibleId): bool
    {
        $query = $this->queryFactory->newSelect('responsibles');
        $query->select('id')->where(['id' => $responsibleId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteResponsibleById(int $responsibleId): void
    {
        $this->queryFactory->newDelete('responsibles')
        ->where(['id' => $responsibleId])
        ->execute();
    }

    private function toRow(array $responsible): array
    { 
        return [
            'nombre' => strtoupper($responsible['nombre']),
            'direccion' => strtoupper($responsible['direccion']),
            'gmail' => $responsible['gmail'],
            'id_charge' => $responsible['id_charge'],
            'created' => $this->fecha,
            'updated' => null
        ];
    }

    private function toRowUpdate(array $responsible): array
    {        
        return [
            'nombre' => strtoupper($responsible['nombre']),
            'direccion' => strtoupper($responsible['direccion']),
            'gmail' => $responsible['gmail'],
            'id_charge' => $responsible['id_charge'],
            'updated' => null
        ];
    }
}
