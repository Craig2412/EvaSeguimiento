<?php

namespace App\Action\Requirements;

use App\Domain\Requirements\Service\RequirementsCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequirementsCreatorAction
{
    private JsonRenderer $renderer;

    private RequirementsCreator $requirementsCreator;

    public function __construct(RequirementsCreator $requirementsCreator, JsonRenderer $renderer)
    {
        $this->requirementsCreator = $requirementsCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $requirementsId = $this->requirementsCreator->createRequirements($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['requirements_id' => $requirementsId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
