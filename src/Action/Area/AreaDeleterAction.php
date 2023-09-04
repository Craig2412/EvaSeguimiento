<?php

namespace App\Action\Area;

use App\Domain\Area\Service\AreaDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaDeleterAction
{
    private AreaDeleter $areaDeleter;

    private JsonRenderer $renderer;

    public function __construct(AreaDeleter $areaDeleter, JsonRenderer $renderer)
    {
        $this->areaDeleter = $areaDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $areaId = (int)$args['area_id'];

        // Invoke the domain (service class)
        $this->areaDeleter->deleteArea($areaId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
