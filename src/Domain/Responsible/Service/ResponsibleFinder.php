<?php

namespace App\Domain\Responsible\Service;

use App\Domain\Responsible\Data\ResponsibleFinderItem;
use App\Domain\Responsible\Data\ResponsibleFinderResult;
use App\Domain\Responsible\Repository\ResponsibleFinderRepository;

final class ResponsibleFinder
{
    private ResponsibleFinderRepository $repository;

    public function __construct(ResponsibleFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findResponsibles(): ResponsibleFinderResult
    {
        // Input validation
        // ...

        $responsibles = $this->repository->findResponsibles();

        return $this->createResult($responsibles);
    }

    private function createResult(array $responsibleRows): ResponsibleFinderResult
    {
        $result = new ResponsibleFinderResult();

        foreach ($responsibleRows as $responsibleRow) {
            $responsible = new ResponsibleFinderItem();
            $responsible->id = $responsibleRow['id'];
            $responsible->nombre = $responsibleRow['nombre'];
            $responsible->direccion = $responsibleRow['direccion'];
            $responsible->gmail = $responsibleRow['gmail'];
            $responsible->id_charge = $responsibleRow['id_charge'];
            $responsible->charge = $responsibleRow['charge'];
            $responsible->created = $responsibleRow['created'];
            $responsible->updated = $responsibleRow['updated'];
            
            $result->responsibles[] = $responsible;
        }

        return $result;
    }
}
