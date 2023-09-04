<?php

namespace App\Action\Status;

use App\Domain\Status\Data\StatusFinderResult;
use App\Domain\Status\Service\StatusFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StatusFinderAction
{
    private StatusFinder $statusFinder;

    private JsonRenderer $renderer;

    public function __construct(StatusFinder $statusFinder, JsonRenderer $jsonRenderer)
    {
        $this->statusFinder = $statusFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $statuss = $this->statusFinder->findStatuss();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($statuss));
    }

    public function transform(StatusFinderResult $result): array
    {
        $statuss = [];

        foreach ($result->statuss as $status) {
            $statuss[] = [
                'id' => $status->id,
                'status' => $status->status
            ];
        }

        return [
            'statuss' => $statuss,
        ];
    }
}
