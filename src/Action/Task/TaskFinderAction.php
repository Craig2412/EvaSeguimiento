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
            $params = json_decode($params[0]);          
            $parametros = $clase_busqueda->whereGenerate($params,'appointments');          
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

En el código que analizamos anteriormente, la variable $args debe tener un parámetro llamado 'params' que contenga un valor específico. Este valor debe ser una cadena de texto en formato JSON. Por lo tanto, para enviar el valor adecuado en la variable $args['params'], debes asegurarte de que sea una cadena de texto en formato JSON válido. 
 
Aquí tienes un ejemplo de cómo podrías enviar el valor en la variable $args['params']: 
 
$args['params'] = '{"format_appointment": "some_value", "name": "some_name", "surname": "some_surname"}'; 
 
En este ejemplo, se utiliza un objeto JSON con las claves 'format_appointment', 'name' y 'surname', y se les asignan algunos valores. Puedes ajustar los valores y las claves según tus necesidades. 
 
Recuerda que este es solo un ejemplo y debes adaptarlo a tu caso específico, asegurándote de que el valor en la variable $args['params'] sea una cadena de texto en formato JSON válido.

*/