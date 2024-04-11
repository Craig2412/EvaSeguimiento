<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Data\EncuestaFinderResult;
use App\Domain\Encuesta\Service\EncuestaFiltroPregFuncFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class EncuestaFiltroPregFuncFinderAction
{
    private EncuestaFiltroPregFuncFinder $EncuestaFiltroPregFuncsFinder;

    private JsonRenderer $renderer;

    public function __construct(EncuestaFiltroPregFuncFinder $EncuestaFiltroPregFuncsFinder, JsonRenderer $jsonRenderer)
    {
        $this->EncuestaFiltroPregFuncsFinder = $EncuestaFiltroPregFuncsFinder;
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

        $fecha_inicial = $args['fecha_inicial'];
        $fecha_final = $args['fecha_final'];

        $tipo_consulta = $args['preguntas_funcionarios'];//Preguntas o funcionarios (1 - 2)
        $tipo_consulta = $args['id'];//ID de lo que buscamos

        $EncuestaFiltroPregFuncs = $this->EncuestaFiltroPregFuncsFinder->findEncuestaFiltroPregFunc($nro_pag,$cant_registros,$fecha_inicial,$fecha_final);
    //Fin Paginador

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($EncuestaFiltroPregFuncs));
    }

    public function transform(EncuestaFinderResult $result): array
    {
        $EncuestaFiltroPregFuncs = [];

        foreach ($result->EncuestaFiltroPregFunc as $EncuestaFiltroPregFunc) {
            $EncuestaFiltroPregFuncs[] = [
                'id' => $encuesta->id,
                'id_funcionario' => $encuesta->id_funcionario,
                'funcionario' => $encuesta->funcionario,
                'id_pregunta' => $encuesta->id_pregunta,
                'pregunta' => $encuesta->pregunta,
                'respuesta' => $encuesta->respuesta
            ];
        }

        return [
            'EncuestaFiltroPregFuncs' => $EncuestaFiltroPregFuncs,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_EncuestaFiltroPregFuncs": "some_surname"}
 
*/