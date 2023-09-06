<?php

namespace App\Action\Responsible;

use App\Domain\Responsible\Service\ResponsibleUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResponsibleUpdaterAction
{
    private ResponsibleUpdater $responsibleUpdater;

    private JsonRenderer $renderer;

    public function __construct(ResponsibleUpdater $responsibleUpdater, JsonRenderer $jsonRenderer)
    {
        $this->responsibleUpdater = $responsibleUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $responsibleId = (int)$args['responsible_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->responsibleUpdater->updateResponsible($responsibleId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
