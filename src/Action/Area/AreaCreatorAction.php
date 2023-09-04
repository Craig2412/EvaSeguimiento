<?php

namespace App\Action\Area;

use App\Domain\Area\Service\AreaCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaCreatorAction
{
    private JsonRenderer $renderer;

    private AreaCreator $areaCreator;

    public function __construct(AreaCreator $areaCreator, JsonRenderer $renderer)
    {
        $this->areaCreator = $areaCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $areaId = $this->areaCreator->createArea($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['area_id' => $areaId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
