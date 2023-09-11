<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskbyResponsableAllFinderResult;
use App\Domain\Task\Service\TaskbyResponsableAllFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;



final class TaskbyResponsableAllFinderAction
{
    private TaskbyResponsableAllFinder $taskbyResponsablesFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskbyResponsableAllFinder $taskbyResponsablesFinder, JsonRenderer $jsonRenderer)
    {
        $this->taskbyResponsablesFinder = $taskbyResponsablesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $taskbyResponsables = $this->taskbyResponsablesFinder->findTaskbyResponsableAll();
 
        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($taskbyResponsables));
    }

    public function transform(TaskbyResponsableAllFinderResult $result): array
    {
        $taskbyResponsables = [];
        
        foreach ($result->taskbyResponsable as $taskbyResponsable) {
            $taskbyResponsables[] = [
                'title' => $taskbyResponsable->direccion,
                'totales' => $taskbyResponsable->total,
                'completados' => $taskbyResponsable->completado,
                'resto' => $taskbyResponsable->total - $taskbyResponsable->completado           
            ];
        }

        return [
            'taskbyResponsables' => $taskbyResponsables,
        ];
    }
}
