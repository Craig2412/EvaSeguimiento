<?php

namespace App\Action\Area;

use App\Domain\Area\Data\AreaReaderResult;
use App\Domain\Area\Service\AreaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaReaderAction
{
    private AreaReader $areaReader;

    private JsonRenderer $renderer;

    public function __construct(AreaReader $areaReader, JsonRenderer $jsonRenderer)
    {
        $this->areaReader = $areaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $areaId = (int)$args['area_id'];

        // Invoke the domain and get the result
        $area = $this->areaReader->getArea($areaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($area));
    }

    private function transform(AreaReaderResult $area): array
    {
        return [
            'id' => $area->id,
            'area' => $area->area,
            'descripcion' => $area->descripcion,
            'created' => $area->created,
            'updated' => $area->updated
        ];
    }
}
