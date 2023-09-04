<?php

namespace App\Domain\Requirements\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RequirementsRepositoryUpdate
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->fecha = date("d-m-Y H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
    }

    public function updateRequirements(int $requirementsId, array $requirements): array
    {
        $row = $this->toRow($requirements);
        $this->queryFactory->newUpdate('requirements', $row)
            ->where(['id' => $requirementsId])
            ->execute();
            return $row;
    }

    public function existsRequirementsId(int $requirementsId): bool
    {
        $query = $this->queryFactory->newSelect('requirements');
        $query->select('id')->where(['id' => $requirementsId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteRequirementsById(int $requirementsId): void
    {
        $this->queryFactory->newDelete('requirements')
            ->where(['id' => $requirementsId])
            ->execute();
    }

    private function toRow(array $requirements): array
    {
        return [
            'id_status' => $requirements['id_status'],
            'updated' => $this->fecha
        ];
    }
}
