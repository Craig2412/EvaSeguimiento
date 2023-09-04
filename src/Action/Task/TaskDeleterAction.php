<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskDeleterAction
{
    private TaskDeleter $taskDeleter;

    private JsonRenderer $renderer;

    public function __construct(TaskDeleter $taskDeleter, JsonRenderer $renderer)
    {
        $this->taskDeleter = $taskDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $taskId = (int)$args['task_id'];
        // Invoke the domain (service class)
        $this->taskDeleter->deleteTask($taskId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
