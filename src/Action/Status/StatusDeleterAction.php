<?php

namespace App\Action\Status;

use App\Domain\Status\Service\StatusDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StatusDeleterAction
{
    private StatusDeleter $statusDeleter;

    private JsonRenderer $renderer;

    public function __construct(StatusDeleter $statusDeleter, JsonRenderer $renderer)
    {
        $this->statusDeleter = $statusDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $statusId = (int)$args['status_id'];

        // Invoke the domain (service class)
        $this->statusDeleter->deleteStatus($statusId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
