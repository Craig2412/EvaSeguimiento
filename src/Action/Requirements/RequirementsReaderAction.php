<?php

namespace App\Action\Requirements;

use App\Domain\Requirements\Data\RequirementsReaderResult;
use App\Domain\Requirements\Service\RequirementsReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequirementsReaderAction
{
    private RequirementsReader $requirementReader;

    private JsonRenderer $renderer;

    public function __construct(RequirementsReader $requirementReader, JsonRenderer $jsonRenderer)
    {
        $this->requirementReader = $requirementReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $requirementId = (int)$args['id_requirement'];

        // Invoke the domain and get the result
        $requirement = $this->requirementReader->getRequirements($requirementId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($requirement));
    }

    private function transform(RequirementsReaderResult $requirement): array
    {
        return [
            
            'id' => $requirement->id,
            'format_appointment' => $requirement->format_appointment,
            'name' => $requirement->name.' '.$requirement->surname,//worker
            'status' => $requirement->status,
            'created' => $requirement->created,
            'updated' => $requirement->updated
            
        ];
    }
}
