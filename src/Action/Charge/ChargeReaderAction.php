<?php

namespace App\Action\Charge;

use App\Domain\Charge\Data\ChargeReaderResult;
use App\Domain\Charge\Service\ChargeReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChargeReaderAction
{
    private ChargeReader $chargeReader;

    private JsonRenderer $renderer;

    public function __construct(ChargeReader $chargeReader, JsonRenderer $jsonRenderer)
    {
        $this->chargeReader = $chargeReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $chargeId = (int)$args['charge_id'];

        // Invoke the domain and get the result
        $charge = $this->chargeReader->getCharge($chargeId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($charge));
    }

    private function transform(ChargeReaderResult $charge): array
    {
        return [
            'id' => $charge->id,
            'charge' => $charge->charge
        ];
    }
}
