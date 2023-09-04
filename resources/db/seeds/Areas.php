<?php


use Phinx\Seed\AbstractSeed;

class Areas extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'area' => 'DESPACHO',
                'descripcion' => null,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 2,
                'area'    => 'DIRECCION GENERAL',
                'descripcion' => null,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 3,
                'area'    => 'DIRECCIONES DE LINEA',
                'descripcion' => null,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ]
        ];
            $posts = $this->table('areas');
            $posts->insert($data)
                  ->saveData();
        }

}
