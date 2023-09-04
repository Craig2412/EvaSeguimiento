<?php

namespace App\Action\Charge;

use App\Domain\Charge\Service\ChargeUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChargeUpdaterAction
{
    private ChargeUpdater $chargeUpdater;

    private JsonRenderer $renderer;

    public function __construct(ChargeUpdater $chargeUpdater, JsonRenderer $jsonRenderer)
    {
        $this->chargeUpdater = $chargeUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $chargeId = (int)$args['charge_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->chargeUpdater->updateCharge($chargeId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
