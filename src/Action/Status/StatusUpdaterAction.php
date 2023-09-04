<?php

namespace App\Action\Status;

use App\Domain\Status\Service\StatusUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StatusUpdaterAction
{
    private StatusUpdater $statusUpdater;

    private JsonRenderer $renderer;

    public function __construct(StatusUpdater $statusUpdater, JsonRenderer $jsonRenderer)
    {
        $this->statusUpdater = $statusUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $statusId = (int)$args['status_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->statusUpdater->updateStatus($statusId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
