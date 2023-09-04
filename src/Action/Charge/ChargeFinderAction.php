<?php

namespace App\Action\Charge;

use App\Domain\Charge\Data\ChargeFinderResult;
use App\Domain\Charge\Service\ChargeFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChargeFinderAction
{
    private ChargeFinder $chargeFinder;

    private JsonRenderer $renderer;

    public function __construct(ChargeFinder $chargeFinder, JsonRenderer $jsonRenderer)
    {
        $this->chargeFinder = $chargeFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
      
        $charges = $this->chargeFinder->findCharges();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($charges));
    }

    public function transform(ChargeFinderResult $result): array
    {
        $charges = [];

        foreach ($result->charges as $charge) {
            $charges[] = [
                'id' => $charge->id,
                'charge' => $charge->charge                
            ];
        }

        return [
            'charges' => $charges,
        ];
    }
}
