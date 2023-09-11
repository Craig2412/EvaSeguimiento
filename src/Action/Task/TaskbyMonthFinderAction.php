<?php

namespace App\Action\Task;

use App\Domain\Task\Data\TaskbyMonthFinderResult;
use App\Domain\Task\Service\TaskbyMonthFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskbyMonthFinderAction
{
    
    private TaskbyMonthFinder $taskbyMonthsFinder;

    private JsonRenderer $renderer;

    public function __construct(TaskbyMonthFinder $taskbyMonthsFinder, JsonRenderer $jsonRenderer)
    {

        $this->taskbyMonthsFinder = $taskbyMonthsFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $year = (int)$args['year'];
       
        $taskbyMonths = $this->taskbyMonthsFinder->findTaskbyMonth($year);
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($taskbyMonths));
    }

    public function transform(TaskbyMonthFinderResult $result): array
    {
        
        $taskbyMonths = [];

        foreach ($result->taskbyMonth as $taskbyMonth) {
            $taskbyMonths[] = [
                strtoupper($taskbyMonth->month),
                $taskbyMonth->total,
            ];
        }

        return [
            'taskbyMonths' => $taskbyMonths,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_taskbyMonths": "some_surname"}
 
*/