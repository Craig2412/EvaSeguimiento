<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskbyMonthFinderItem;
use App\Domain\Task\Data\TaskbyMonthFinderResult;
use App\Domain\Task\Repository\TaskbyMonthFinderRepository;

function obtenerNombreMes($numeroMes) {
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    if (isset($meses[$numeroMes])) {
        return $meses[$numeroMes];
    } else {
        return 'Tareas sin culminar';
    }
}

final class TaskbyMonthFinder
{
    private TaskbyMonthFinderRepository $repository;

    public function __construct(TaskbyMonthFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskbyMonth(int $year): TaskbyMonthFinderResult
    {
        // Input validation
        $taskbyMonth = $this->repository->findTaskbyMonth($year);

        return $this->createResult($taskbyMonth);
    }

    private function createResult(array $taskbyMonthRows): TaskbyMonthFinderResult
    {
        $result = new TaskbyMonthFinderResult();
        
        foreach ($taskbyMonthRows as $taskbyMonthRow) {
            $taskbyMonth = new TaskbyMonthFinderItem();
           
            $taskbyMonth->month = obtenerNombreMes($taskbyMonthRow['month']);
            $taskbyMonth->total = $taskbyMonthRow['total'];
            

            $result->taskbyMonth[] = $taskbyMonth;
        }
        
        return $result;
    }
}
