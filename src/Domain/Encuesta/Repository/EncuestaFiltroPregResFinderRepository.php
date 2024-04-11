<?php

namespace App\Domain\Encuesta\Repository;

use App\Factory\QueryFactory;

final class EncuestaFiltroPregFuncFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEncuestaFiltroPregFunc($nro_pag,$cant_registros,$fecha_inicial,$fecha_final): array
    {
        //Paginador
        $limit = $cant_registros;
        $offset = ($nro_pag - 1) * $limit;
        $query = $this->queryFactory->newSelect('encuestas');
        //Fin Paginador
        
        $query->select(
            [
                'encuesta.id',
                'encuesta.id_funcionario',
                'encuesta.id_pregunta',
                'funcionarios.apellidos_nombres',
                'preguntas.pregunta',
                'encuesta.respuesta'
            ])

            ->leftjoin(['funcionarios'=>'funcionarios'], 'funcionarios.id = encuesta.id_funcionario')
            ->leftjoin(['preguntas'=>'preguntas'], 'preguntas.id = encuesta.id_pregunta');
            if ($pregFuncp == 1) {
                $query  ->where(['id_pregunta' => $encuestaId])
                        ->where(function ($exp, $q) use ($fecha_inicial, $fecha_final) {
                            return $exp->between('encuestas.estimated_date', $fecha_inicial, $fecha_final);
                        }, []);
            }else {
                $query->where(['id_funcionario' => $encuestaId]);
            }
       
        

        //Paginador
            $query->offset([$offset]);
            $query->limit([$limit]);
        //Fin paginador

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
