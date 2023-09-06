<?php

namespace App\Action\Responsible;

use App\Domain\Responsible\Data\ResponsibleFinderResult;
use App\Domain\Responsible\Service\ResponsibleFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResponsibleFinderAction
{
    private ResponsibleFinder $responsibleFinder;

    private JsonRenderer $renderer;

    public function __construct(ResponsibleFinder $responsibleFinder, JsonRenderer $jsonRenderer)
    {
        $this->responsibleFinder = $responsibleFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $responsibles = $this->responsibleFinder->findResponsibles();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($responsibles));
    }

    public function transform(ResponsibleFinderResult $result): array
    {
        $responsibles = [];

        foreach ($result->responsibles as $responsible) {
            $responsibles[] = [
                'id' => $responsible->id,
                'nombre' => $responsible->nombre,
                'direccion' => $responsible->direccion,
                'gmail' => $responsible->gmail,
                'id_charge' => $responsible->id_charge,
                'charge' => $responsible->charge,
                'created' => $responsible->created,
                'updated' => $responsible->updated
            ];
        }

        return [
            'responsibles' => $responsibles,
        ];
    }
}
