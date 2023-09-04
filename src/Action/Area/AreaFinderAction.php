<?php

namespace App\Action\Area;

use App\Domain\Area\Data\AreaFinderResult;
use App\Domain\Area\Service\AreaFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaFinderAction
{
    private AreaFinder $areaFinder;

    private JsonRenderer $renderer;

    public function __construct(AreaFinder $areaFinder, JsonRenderer $jsonRenderer)
    {
        $this->areaFinder = $areaFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $areas = $this->areaFinder->findAreas();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($areas));
    }

    public function transform(AreaFinderResult $result): array
    {
        $areas = [];

        foreach ($result->areas as $area) {
            $areas[] = [
                'id' => $area->id,
                'area' => $area->area,
                'descripcion' => $area->descripcion,
                'created' => $area->created,
                'updated' => $area->updated
            ];
        }

        return [
            'areas' => $areas,
        ];
    }
}
