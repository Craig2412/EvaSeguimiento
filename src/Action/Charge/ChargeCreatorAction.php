<?php

namespace App\Action\Charge;

use App\Domain\Charge\Service\ChargeCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChargeCreatorAction
{
    private JsonRenderer $renderer;

    private ChargeCreator $chargeCreator;

    public function __construct(ChargeCreator $chargeCreator, JsonRenderer $renderer)
    {
        $this->chargeCreator = $chargeCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $chargeId = $this->chargeCreator->createCharge($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['charge_id' => $chargeId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
