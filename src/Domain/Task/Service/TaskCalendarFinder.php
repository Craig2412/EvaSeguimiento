<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskFinderItem;
use App\Domain\Task\Data\TaskFinderResult;
use App\Domain\Task\Repository\TaskCalendarFinderRepository;

final class TaskCalendarFinder
{
    private TaskCalendarFinderRepository $repository;

    public function __construct(TaskCalendarFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskCalendar($nro_pag,$cant_registros,$fecha_inicial,$fecha_final): TaskFinderResult
    {
        // Input validation
        $taskCalendar = $this->repository->findTaskCalendar($nro_pag,$cant_registros,$fecha_inicial,$fecha_final);

        return $this->createResult($taskCalendar);
    }

    private function createResult(array $taskCalendarRows): TaskFinderResult
    {
        $result = new TaskFinderResult();

        foreach ($taskCalendarRows as $taskCalendarRow) {
            $taskCalendar = new TaskFinderItem();
            
            $taskCalendar->id = $taskCalendarRow['id'];
            $taskCalendar->title = $taskCalendarRow['title'];
            $taskCalendar->description = $taskCalendarRow['description'];
            
            $taskCalendar->id_status = $taskCalendarRow['id_status'];
            $taskCalendar->status = $taskCalendarRow['state'];
            $taskCalendar->id_area = $taskCalendarRow['id_area'];
            $taskCalendar->area = $taskCalendarRow['area'];
            $taskCalendar->id_responsable = $taskCalendarRow['id_responsable'];
            $taskCalendar->nombre = $taskCalendarRow['nombre'];
            $taskCalendar->direccion = $taskCalendarRow['direccion'];
            $taskCalendar->id_type_taskCalendar = $taskCalendarRow['id_type_taskCalendar'];
            $taskCalendar->type_taskCalendar = $taskCalendarRow['tipo_tarea'];

            $taskCalendar->initial_date = $taskCalendarRow['initial_date'];
            $taskCalendar->estimated_date = $taskCalendarRow['estimated_date'];
            $taskCalendar->due_date = $taskCalendarRow['due_date'];
            $taskCalendar->created = $taskCalendarRow['created'];
            $taskCalendar->updated = $taskCalendarRow['updated'];
            

            $result->taskCalendar[] = $taskCalendar;
        }
        
        return $result;
    }
}
