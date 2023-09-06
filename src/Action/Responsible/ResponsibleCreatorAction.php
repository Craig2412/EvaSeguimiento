<?php

namespace App\Action\Responsible;

use App\Domain\Responsible\Service\ResponsibleCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResponsibleCreatorAction
{
    private JsonRenderer $renderer;

    private ResponsibleCreator $responsibleCreator;

    public function __construct(ResponsibleCreator $responsibleCreator, JsonRenderer $renderer)
    {
        $this->responsibleCreator = $responsibleCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $responsibleId = $this->responsibleCreator->createResponsible($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['responsible_id' => $responsibleId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
