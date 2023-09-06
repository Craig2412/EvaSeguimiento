<?php

namespace App\Action\Responsible;

use App\Domain\Responsible\Service\ResponsibleDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResponsibleDeleterAction
{
    private ResponsibleDeleter $responsibleDeleter;

    private JsonRenderer $renderer;

    public function __construct(ResponsibleDeleter $responsibleDeleter, JsonRenderer $renderer)
    {
        $this->responsibleDeleter = $responsibleDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $responsibleId = (int)$args['responsible_id'];

        // Invoke the domain (service class)
        $this->responsibleDeleter->deleteResponsible($responsibleId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
