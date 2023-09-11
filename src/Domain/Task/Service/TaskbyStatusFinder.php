<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskbyStatusFinderItem;
use App\Domain\Task\Data\TaskbyStatusFinderResult;
use App\Domain\Task\Repository\TaskbyStatusFinderRepository;

function obtenerNombreStatus($numeroStatus) {
    $meses = [
        1 => 'POR INICIAR',
        2 => 'EN PROCESO',
        3 => 'CULMINADO',
        4 => 'DETENIDO'
    ];

    if (isset($meses[$numeroStatus])) {
        return $meses[$numeroStatus];
    } else {
        return 'Tareas sin culminar';
    }
}

final class TaskbyStatusFinder
{
    private TaskbyStatusFinderRepository $repository;

    public function __construct(TaskbyStatusFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskbyStatus(int $busquedaId, int $value): TaskbyStatusFinderResult
    {
        // Input validation
        $taskbyStatus = $this->repository->findTaskbyStatus($busquedaId,$value);

        return $this->createResult($taskbyStatus);
    }

    private function createResult(array $taskbyStatusRows): TaskbyStatusFinderResult
    {
        $result = new TaskbyStatusFinderResult();
        
        foreach ($taskbyStatusRows as $taskbyStatusRow) {
            $taskbyStatus = new TaskbyStatusFinderItem();
           
            $taskbyStatus->state = obtenerNombreStatus($taskbyStatusRow['id_status']);
            $taskbyStatus->total = $taskbyStatusRow['total'];
            

            $result->taskbyStatus[] = $taskbyStatus;
        }
        
        return $result;
    }
}
