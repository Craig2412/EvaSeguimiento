<?php

namespace App\Action\Responsible;

use App\Domain\Responsible\Data\ResponsibleReaderResult;
use App\Domain\Responsible\Service\ResponsibleReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResponsibleReaderAction
{
    private ResponsibleReader $responsibleReader;

    private JsonRenderer $renderer;

    public function __construct(ResponsibleReader $responsibleReader, JsonRenderer $jsonRenderer)
    {
        $this->responsibleReader = $responsibleReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $responsibleId = (int)$args['responsible_id'];

        // Invoke the domain and get the result
        $responsible = $this->responsibleReader->getResponsible($responsibleId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($responsible));
    }

    private function transform(ResponsibleReaderResult $responsible): array
    {
        return [
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
}
