<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskCreatorAction
{
    private JsonRenderer $renderer;

    private TaskCreator $taskCreator;

    public function __construct(TaskCreator $taskCreator, JsonRenderer $renderer)
    {
        $this->taskCreator = $taskCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $taskId = $this->taskCreator->createTask($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['task_id' => $taskId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
