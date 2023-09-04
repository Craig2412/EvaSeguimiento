<?php

namespace App\Domain\TypeTask\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TypeTaskRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertTypeTask(array $typeTask): int
    {
        return (int)$this->queryFactory->newInsert('typeTasks', $this->toRow($typeTask))
        ->execute()
        ->lastInsertId();
    }
    
    public function getTypeTaskById(int $typeTaskId): array
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

                $query->where(['type_tasks.id_area' => $typeTaskId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('TypeTask not found: %s', $typeTaskId));
        }
        
        return $row;
    }
    
    public function updateTypeTask(int $typeTaskId, array $typeTask): array
    {
        $row = $this->toRow($typeTask);
        
        $this->queryFactory->newUpdate('typeTasks', $row)
        ->where(['id' => $typeTaskId])
        ->execute();

        return $row;

    }

    public function existsTypeTaskId(int $typeTaskId): bool
    {
        $query = $this->queryFactory->newSelect('typeTasks');
        $query->select('id')->where(['id' => $typeTaskId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteTypeTaskById(int $typeTaskId): void
    {
        
        $this->queryFactory->newDelete('typeTasks')
        ->where(['id' => $typeTaskId])
        ->execute();
        
    }

    private function toRow(array $typeTask): array
    {
        
        $updated = isset($typeTask['updated']) ? $typeTask['updated'] : null;
        
        return [
            'typeTask' => strtoupper($typeTask['typeTask']),
            'descripcion' => $typeTask['descripcion'],
            'area' => $typeTask['area'],
            'created' => $this->fecha,
            'updated' => $updated
            
        ];
    }
}
