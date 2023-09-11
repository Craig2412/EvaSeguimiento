<?php

namespace App\Domain\Requirements\Service;

use App\Domain\Requirements\Data\RequirementsFinderItem;
use App\Domain\Requirements\Data\RequirementsFinderResult;
use App\Domain\Requirements\Repository\RequirementsFinderRepository;

final class RequirementsFinder
{
    private RequirementsFinderRepository $repository;

    public function __construct(RequirementsFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRequirements($nro_pag,$where,$cant_registros): RequirementsFinderResult
    {
        // Input validation
        $requirements = $this->repository->findRequirements($nro_pag,$where,$cant_registros);

        return $this->createResult($requirements);
    }

    private function createResult(array $requirementsRows): RequirementsFinderResult
    {
        $result = new RequirementsFinderResult();

        foreach ($requirementsRows as $requirementsRow) {
            $requirements = new RequirementsFinderItem();
            $requirements->id = $requirementsRow['id'];
            $requirements->format_appointment = $requirementsRow['format_appointment'];
            $requirements->name = $requirementsRow['name'];
            $requirements->surname = $requirementsRow['surname'];
            $requirements->status = $requirementsRow['status'];
            $requirements->created = $requirementsRow['created'];
            $requirements->updated = $requirementsRow['updated'];

            $result->requirements[] = $requirements;
        }
        return $result;
    }
}
