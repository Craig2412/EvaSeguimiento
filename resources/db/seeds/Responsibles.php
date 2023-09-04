<?php


use Phinx\Seed\AbstractSeed;

class Responsibles extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'nombre'    => 'Angie Amaro',
                'direccion' => 'DIRECCION DE MARCAS',
                'gmail' => '0@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 2,
                'nombre'    => 'Ana Karina Rotte Mora',
                'direccion' => 'OFICINA DE ASUNTOS INTERNACIONALES',
                'gmail' => '01@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 3,
                'nombre'    => 'Bestalia Romero',
                'direccion' => 'OFICINA DE ATENCION AL CIUDADANO',
                'gmail' => '02@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 4,
                'nombre'    => 'Edison Aponte',
                'direccion' => 'OFICINA DE PLANIFICACION Y PRESUPUESTO',
                'gmail' => '03@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 5,
                'nombre'    => 'Evelyn Cardenas',
                'direccion' => 'DIRECCION DEL DESPACHO',
                'gmail' => '04@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 6,
                'nombre'    => 'Rosalba Feggali',
                'direccion' => 'DIRECCION DE DERECHO DE AUTOR',
                'gmail' => '05@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 7,
                'nombre'    => 'Tomas Guite',
                'direccion' => 'DIRECCION DEL REGISTRO',
                'gmail' => '06@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 8,
                'nombre'    => 'Franyerlin Prieto',
                'direccion' => 'OFICINA DE DIFUSION',
                'gmail' => '07@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 9,
                'nombre'    => 'Zulay Poggi',
                'direccion' => 'DIRECCION DE INDICACIONES GEOGRAFICAS PROTEGIDAS',
                'gmail' => '08@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 10,
                'nombre'    => 'Ivan Matute',
                'direccion' => 'OFICINA DE TECNOLOGIA',
                'gmail' => '09@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 11,
                'nombre'    => 'Yolly Martinez',
                'direccion' => 'OFICINA DE GESTION HUMANA',
                'gmail' => '010@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 12,
                'nombre'    => 'Judith Rodriguez',
                'direccion' => 'DIRECCION DE PATENTES',
                'gmail' => '011@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 13,
                'nombre'    => 'Kerina Guerrero',
                'direccion' => 'Asesoria Juridica',
                'gmail' => '012@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 14,
                'nombre'    => 'Edgar Quintero',
                'direccion' => 'OFICINA DE GESTION ADMINISTRATIVA',
                'gmail' => '013@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 15,
                'nombre'    => 'Briguel Martinez',
                'direccion' => 'OFICINA DE POLITICAS PUBLICAS',
                'gmail' => '014@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 16,
                'nombre'    => 'Luis Villegas',
                'direccion' => 'DIRECCION GENERAL',
                'gmail' => '015@gmail.com',
                'id_charge' => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ]
        ];
        $posts = $this->table('responsibles');
        $posts->insert($data)
              ->saveData();
    }
}
