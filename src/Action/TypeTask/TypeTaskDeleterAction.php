<?php

namespace App\Action\TypeTask;

use App\Domain\TypeTask\Service\TypeTaskDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TypeTaskDeleterAction
{
    private TypeTaskDeleter $typeTaskDeleter;

    private JsonRenderer $renderer;

    public function __construct(TypeTaskDeleter $typeTaskDeleter, JsonRenderer $renderer)
    {
        $this->typeTaskDeleter = $typeTaskDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $typeTaskId = (int)$args['typeTask_id'];

        // Invoke the domain (service class)
        $this->typeTaskDeleter->deleteTypeTask($typeTaskId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
