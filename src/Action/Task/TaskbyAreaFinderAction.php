<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskbyAreaFinderResult;
use App\Domain\Task\Service\TaskbyAreaFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskbyAreaFinderAction
{
    
    private TaskbyAreaFinder $taskbyAreasFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskbyAreaFinder $taskbyAreasFinder, JsonRenderer $jsonRenderer)
    {

        $this->taskbyAreasFinder = $taskbyAreasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $taskbyAreas = $this->taskbyAreasFinder->findTaskbyArea();
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($taskbyAreas));
    }

    public function transform(TaskbyAreaFinderResult $result): array
    {
        $taskbyAreas = [];

        foreach ($result->taskbyArea as $taskbyArea) {
            $taskbyAreas[] = [
                'area' => $taskbyArea->area,
                'total' => $taskbyArea->total,
            ];
        }

        return [
            'taskbyAreas' => $taskbyAreas,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_taskbyAreas": "some_surname"}
*/