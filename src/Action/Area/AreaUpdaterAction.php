<?php

namespace App\Action\Area;

use App\Domain\Area\Service\AreaUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaUpdaterAction
{
    private AreaUpdater $areaUpdater;

    private JsonRenderer $renderer;

    public function __construct(AreaUpdater $areaUpdater, JsonRenderer $jsonRenderer)
    {
        $this->areaUpdater = $areaUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $areaId = (int)$args['area_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->areaUpdater->updateArea($areaId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
