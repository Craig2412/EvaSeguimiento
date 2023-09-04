<?php

namespace App\Action\Status;

use App\Domain\Status\Service\StatusCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StatusCreatorAction
{
    private JsonRenderer $renderer;

    private StatusCreator $statusCreator;

    public function __construct(StatusCreator $statusCreator, JsonRenderer $renderer)
    {
        $this->statusCreator = $statusCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $statusId = $this->statusCreator->createStatus($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['status_id' => $statusId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
