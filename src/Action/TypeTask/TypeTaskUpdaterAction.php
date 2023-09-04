<?php

namespace App\Action\TypeTask;

use App\Domain\TypeTask\Service\TypeTaskUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TypeTaskUpdaterAction
{
    private TypeTaskUpdater $typeTaskUpdater;

    private JsonRenderer $renderer;

    public function __construct(TypeTaskUpdater $typeTaskUpdater, JsonRenderer $jsonRenderer)
    {
        $this->typeTaskUpdater = $typeTaskUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $typeTaskId = (int)$args['typeTask_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->typeTaskUpdater->updateTypeTask($typeTaskId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
