<?php

namespace App\Action\TypeTask;

use App\Domain\TypeTask\Data\TypeTaskFinderResult;
use App\Domain\TypeTask\Service\TypeTaskFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TypeTaskFinderAction
{
    private TypeTaskFinder $typeTaskFinder;

    private JsonRenderer $renderer;

    public function __construct(TypeTaskFinder $typeTaskFinder, JsonRenderer $jsonRenderer)
    {
    
    $this->typeTaskFinder = $typeTaskFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $typeTasks = $this->typeTaskFinder->findTypeTasks();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($typeTasks));
    }

    public function transform(TypeTaskFinderResult $result): array
    {
        $typeTasks = [];

        foreach ($result->typeTasks as $typeTask) {
    
            $typeTasks[] = [
                'id' => $typeTask->id,
                'tipo_tarea' => $typeTask->typeTask,
                'descripcion' => $typeTask->descripcion,
                'area' => $typeTask->area,
                'created' => $typeTask->created,
                'updated' => $typeTask->updated
            ];
        }

        return [
            'typeTasks' => $typeTasks,
        ];
    }
}
