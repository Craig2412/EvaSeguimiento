<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskFinderResult;
use App\Domain\Task\Service\TaskbyResponsableFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;



final class TaskbyResponsableFinderAction
{
    private TaskbyResponsableFinder $taskbyResponsablesFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskbyResponsableFinder $taskbyResponsablesFinder, JsonRenderer $jsonRenderer)
    {
        $this->taskbyResponsablesFinder = $taskbyResponsablesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $responsableId = (int)$args['id_responsable'];

        $taskbyResponsables = $this->taskbyResponsablesFinder->findTaskbyResponsable($responsableId);
 
        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($taskbyResponsables));
    }

    public function transform(TaskFinderResult $result): array
    {
        $taskbyResponsables = [];
        
        foreach ($result->taskbyResponsable as $taskbyResponsable) {
            $taskbyResponsables[] = [
                'id' => $taskbyResponsable->id,
                'title' => $taskbyResponsable->title,
                'description' => $taskbyResponsable->description,//
                'id_status' => $taskbyResponsable->id_status,
                'status' => $taskbyResponsable->status,
                'id_area' => $taskbyResponsable->id_area,
                'area' => $taskbyResponsable->area,
                'id_responsable' => $taskbyResponsable->id_responsable,
                'nombre' => $taskbyResponsable->nombre,
                'direccion' => $taskbyResponsable->direccion,
                'id_type_task' => $taskbyResponsable->id_type_task,
                'type_task' => $taskbyResponsable->type_task,
                'initial_date' => $taskbyResponsable->initial_date,
                'estimated_date' => $taskbyResponsable->estimated_date,
                'due_date' => $taskbyResponsable->due_date,
                'created' => $taskbyResponsable->created,
                'updated' => $taskbyResponsable->updated
            ];
        }

        return [
            'taskbyResponsables' => $taskbyResponsables,
        ];
    }
}
