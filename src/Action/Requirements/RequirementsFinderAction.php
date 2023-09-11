<?php

namespace App\Action\Requirements;

use App\Domain\Requirements\Data\RequirementsFinderResult;
use App\Domain\Requirements\Service\RequirementsFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class RequirementsFinderAction
{
    private RequirementsFinder $requirementsFinder;

    private JsonRenderer $renderer;

    public function __construct(RequirementsFinder $requirementsFinder, JsonRenderer $jsonRenderer)
    {
        $this->requirementsFinder = $requirementsFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

    //Paginador
        if (isset($args['nro_pag']) && ($args['nro_pag'] > 0)) {
            $nro_pag = (int)$args['nro_pag'];
        }else {
            $nro_pag = 1;
        }

        if (isset($args['cant_registros']) && ($args['cant_registros'] > 0)) {
            $cant_registros = $args['cant_registros'];
        }else {
            $cant_registros = 10;
        }

        if (isset($args['params'])) {
            $clase_busqueda = New argValidator;
            $params = explode('/', $args['params']);
            $params = json_decode($params[0]);          
            $parametros = $clase_busqueda->whereGenerate($params,'appointments');          
        }else {
            $parametros = null;
        }

        $requirements = $this->requirementsFinder->findRequirements($nro_pag,$parametros,$cant_registros);
    //Fin Paginador
    //$nro_pag,$parametros,$cant_registros


        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($requirements));
    }

    public function transform(RequirementsFinderResult $result): array
    {
        $requirements = [];

        foreach ($result->requirements as $requirement) {
            $requirements[] = [
                'id' => $requirement->id,
                'format_appointment' => $requirement->format_appointment,
                'name' => $requirement->name.' '.$requirement->surname,//worker
                'status' => $requirement->status,
                'created' => $requirement->created,
                'updated' => $requirement->updated
            ];
        }

        return [
            'requirements' => $requirements,
        ];
    }
}
