<?php

namespace App\Action\Requirements;

use App\Domain\Requirements\Service\RequirementsUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequirementsUpdaterAction
{
    private RequirementsUpdater $requirementsUpdater;

    private JsonRenderer $renderer;

    public function __construct(RequirementsUpdater $requirementsUpdater, JsonRenderer $jsonRenderer)
    {
        $this->requirementsUpdater = $requirementsUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $requirementsId = (int)$args['id_requirement'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->requirementsUpdater->updateRequirements($requirementsId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datos nuevos' => $new_date]);
    }
}
