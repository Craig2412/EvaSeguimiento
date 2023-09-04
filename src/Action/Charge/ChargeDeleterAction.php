<?php

namespace App\Action\Charge;

use App\Domain\Charge\Service\ChargeDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChargeDeleterAction
{
    private ChargeDeleter $chargeDeleter;

    private JsonRenderer $renderer;

    public function __construct(ChargeDeleter $chargeDeleter, JsonRenderer $renderer)
    {
        $this->chargeDeleter = $chargeDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $chargeId = (int)$args['charge_id'];

        // Invoke the domain (service class)
        $this->chargeDeleter->deleteCharge($chargeId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
