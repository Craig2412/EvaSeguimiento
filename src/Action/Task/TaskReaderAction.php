<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskReaderResult;
use App\Domain\Task\Service\TaskReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskReaderAction
{
    private TaskReader $taskReader;

    private JsonRenderer $renderer;

    public function __construct(TaskReader $taskReader, JsonRenderer $jsonRenderer)
    {
        $this->taskReader = $taskReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $taskId = (int)$args['id_task'];

        // Invoke the domain and get the result
        $task = $this->taskReader->getTask($taskId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($task));
    }

    private function transform(TaskReaderResult $task): array
    {
        return [
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
}