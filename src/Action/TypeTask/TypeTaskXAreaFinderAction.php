<?php

namespace App\Action\TypeTask;

use App\Domain\TypeTask\Data\TypeTaskXAreaFinderResult;
use App\Domain\TypeTask\Service\TypeTaskXAreaFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TypeTaskXAreaFinderAction
{
    private TypeTaskXAreaFinder $typeTaskXAreaFinder;

    private JsonRenderer $renderer;

    public function __construct(TypeTaskXAreaFinder $typeTaskXAreaFinder, JsonRenderer $jsonRenderer)
    {
    
    $this->typeTaskXAreaFinder = $typeTaskXAreaFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        // Fetch parameters from the request
        $typeTaskXAreaId = (int)$args['typeArea_id'];
        
        // Optional: Pass parameters from the request to the service method
        // ...

        $typeTaskXAreas = $this->typeTaskXAreaFinder->findTypeTaskXAreas($typeTaskXAreaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($typeTaskXAreas));
    }

    public function transform(TypeTaskXAreaFinderResult $result): array
    {
        $typeTaskXAreas = [];

       // var_dump($result);
        foreach ($result->typeTaskXAreas as $typeTaskXArea) {
            $typeTaskXAreas[] = [
                'id' => $typeTaskXArea->id,
                'tipo_tarea' => $typeTaskXArea->typeTaskXArea,
                'descripcion' => $typeTaskXArea->descripcion,
                'area' => $typeTaskXArea->area,
                'created' => $typeTaskXArea->created,
                'updated' => $typeTaskXArea->updated
            ];
        }

        return [
            'typeTaskXAreas' => $typeTaskXAreas,
        ];
    }
}
