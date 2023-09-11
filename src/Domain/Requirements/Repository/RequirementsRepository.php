<?php

namespace App\Domain\Requirements\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RequirementsRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;

    }

    public function insertRequirements(array $requirements): int
    {

        return (int)$this->queryFactory->newInsert('requirements', $this->toRow($requirements))
            ->execute()
            ->lastInsertId();
    }

    public function getRequirementsById(int $requirementsId): array
    {
        $query = $this->queryFactory->newSelect('requirements');
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

        $query->where(['requirements.id' => $requirementsId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Requirements not found: %s', $requirementsId));
        }

        return $row;
    }

    public function updateRequirements(int $requirementsId, array $requirements): void
    {
        $row = $this->toRow($requirements);

        $this->queryFactory->newUpdate('requirements', $row)
            ->where(['id' => $requirementsId])
            ->execute();
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
            'amount_requests' => $requirements['amount_requests'],
            'id_format_appointment' => $requirements['id_format_appointment'],
            'id_user' => $requirements['id_user'],
            'id_condition' => $requirements['id_condition'],
            'id_status' => $requirements['id_status'],
            'id_worker' => $requirements['id_worker'],
            'created' =>date("d-m-Y H:i:s"),
            'updated' => null
           
        ];
    }
}
