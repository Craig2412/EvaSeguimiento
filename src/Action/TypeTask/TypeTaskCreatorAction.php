<?php

namespace App\Action\TypeTask;

use App\Domain\TypeTask\Service\TypeTaskCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TypeTaskCreatorAction
{
    private JsonRenderer $renderer;

    private TypeTaskCreator $typeTaskCreator;

    public function __construct(TypeTaskCreator $typeTaskCreator, JsonRenderer $renderer)
    {
        $this->typeTaskCreator = $typeTaskCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $typeTaskId = $this->typeTaskCreator->createTypeTask($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['typeTask_id' => $typeTaskId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
