<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskFinderResult;
use App\Domain\Task\Service\TaskFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class TaskFinderAction
{
    private TaskFinder $tasksFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskFinder $tasksFinder, JsonRenderer $jsonRenderer)
    {
        $this->tasksFinder = $tasksFinder;
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

        if (isset($args['params'])) {
            $clase_busqueda = New argValidator;
            $params = explode('/', $args['params']);
            $params = json_decode($params[0], true);    

            $parametros = $clase_busqueda->whereGenerate($params,'tasks');
           

        }else {
            $parametros = null;
        }

        $tasks = $this->tasksFinder->findTask($nro_pag,$parametros,$cant_registros);
    //Fin Paginador
    //$nro_pag,$parametros,$cant_registros


        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tasks));
    }

    public function transform(TaskFinderResult $result): array
    {
        $tasks = [];

        foreach ($result->task as $task) {
            $tasks[] = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,//
                'id_status' => $task->id_status,
                'status' => $task->status,
                'id_area' => $task->id_area,
                'area' => $task->area,
                'id_responsable' => $task->id_responsable,
                'nombre' => $task->nombre,
                'direccion' => $task->direccion,
                'id_type_task' => $task->id_type_task,
                'type_task' => $task->type_task,
                'initial_date' => $task->initial_date,
                'estimated_date' => $task->estimated_date,
                'due_date' => $task->due_date,
                'created' => $task->created,
                'updated' => $task->updated
            ];
        }

        return [
            'tasks' => $tasks,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_tasks": "some_surname"}
 
*/