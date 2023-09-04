<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskUpdaterAction
{
    private TaskUpdater $taskUpdater;

    private JsonRenderer $renderer;

    public function __construct(TaskUpdater $taskUpdater, JsonRenderer $jsonRenderer)
    {
        $this->taskUpdater = $taskUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $taskId = (int)$args['id_requirement'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->taskUpdater->updateTask($taskId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datos nuevos' => $new_date]);
    }
}
