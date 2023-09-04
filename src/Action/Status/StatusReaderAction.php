<?php

namespace App\Action\Status;

use App\Domain\Status\Data\StatusReaderResult;
use App\Domain\Status\Service\StatusReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StatusReaderAction
{
    private StatusReader $statusReader;

    private JsonRenderer $renderer;

    public function __construct(StatusReader $statusReader, JsonRenderer $jsonRenderer)
    {
        $this->statusReader = $statusReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $statusId = (int)$args['status_id'];

        // Invoke the domain and get the result
        $status = $this->statusReader->getStatus($statusId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($status));
    }

    private function transform(StatusReaderResult $status): array
    {
        return [
            'id' => $status->id,
            'status' => $status->status
           
        ];
    }
}
