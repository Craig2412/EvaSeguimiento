<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskFinderResult;
use App\Domain\Task\Service\TaskCalendarFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class TaskCalendarFinderAction
{
    private TaskCalendarFinder $taskCalendarsFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskCalendarFinder $taskCalendarsFinder, JsonRenderer $jsonRenderer)
    {
        $this->taskCalendarsFinder = $taskCalendarsFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        
    //Paginador
        if (isset($args['nro_pag']) && ($args['nro_pag'] > 0)) {
            $nro_pag = (int)$args['nro_pag'];
        }else {
            $nro_pag = 1;
        }

        if (isset($args['cant_registros']) && ($args['cant_registros'] > 0)) {
            $cant_registros = $args['cant_registros'];
        }else {
            $cant_registros = 10;
        }

        $fecha_inicial = $args['fecha_inicial'];
        $fecha_final = $args['fecha_final'];

        $taskCalendars = $this->taskCalendarsFinder->findTaskCalendar($nro_pag,$cant_registros,$fecha_inicial,$fecha_final);
    //Fin Paginador

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($taskCalendars));
    }

    public function transform(TaskFinderResult $result): array
    {
        $taskCalendars = [];

        foreach ($result->taskCalendar as $taskCalendar) {
            $taskCalendars[] = [
                'id' => $taskCalendar->id,
                'title' => $taskCalendar->title,
                'start' => date("D M d Y H:i:s \G\M\TO (e)", strtotime($taskCalendar->estimated_date)),
                'end' => date("D M d Y H:i:s \G\M\TO (e)", strtotime($taskCalendar->estimated_date)),
                //date("d-m-Y", strtotime($taskCalendar->initial_date));
                //date("d-m-Y", strtotime($taskCalendar->estimated_date));

                'description' => $taskCalendar->description,//
                'id_status' => $taskCalendar->id_status,
                'status' => $taskCalendar->status,
                'id_area' => $taskCalendar->id_area,
                'area' => $taskCalendar->area,
                'id_responsable' => $taskCalendar->id_responsable,
                'nombre' => $taskCalendar->nombre,
                'direccion' => $taskCalendar->direccion,
                'id_type_taskCalendar' => $taskCalendar->id_type_taskCalendar,
                'type_taskCalendar' => $taskCalendar->type_taskCalendar,
                
                'due_date' => $taskCalendar->due_date,
                'created' => $taskCalendar->created,
                'updated' => $taskCalendar->updated
            ];
        }

        return [
            'taskCalendars' => $taskCalendars,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_taskCalendars": "some_surname"}
 
*/