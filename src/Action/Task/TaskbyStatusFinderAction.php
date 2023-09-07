<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskbyStatusFinderResult;
use App\Domain\Task\Service\TaskbyStatusFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskbyStatusFinderAction
{
    
    private TaskbyStatusFinder $taskbyStatussFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskbyStatusFinder $taskbyStatussFinder, JsonRenderer $jsonRenderer)
    {

        $this->taskbyStatussFinder = $taskbyStatussFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $value = (int)$args['value'];
        $busquedaId = (int)$args['id_busqueda']; 
       
        $taskbyStatuss = $this->taskbyStatussFinder->findTaskbyStatus($busquedaId,$value);
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($taskbyStatuss));
    }

    public function transform(TaskbyStatusFinderResult $result): array
    {
        
        $taskbyStatuss = [];

        foreach ($result->taskbyStatus as $taskbyStatus) {
            $taskbyStatuss[] = [
                'state' => $taskbyStatus->state,
                'total' => $taskbyStatus->total,
            ];
        }

        return [
            'taskbyStatuss' => $taskbyStatuss,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_taskbyStatuss": "some_surname"}
 
*/