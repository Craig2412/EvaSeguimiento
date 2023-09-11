<?php


use Phinx\Seed\AbstractSeed;

class TypeTasks extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'tipo_tarea'  => 'REUNIONES',
                'descripcion' => null,
                'id_area' => '3',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 2,
                'tipo_tarea'  => 'INSTRUCCIONES',
                'descripcion' => null,
                'id_area' => '3',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 3,
                'tipo_tarea'  => 'AGENDA',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 4,
                'tipo_tarea'  => 'CASOS VIP',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 5,
                'tipo_tarea'  => 'INVITACIONES',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 6,
                'tipo_tarea'  => 'AUDIENCIAS',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 7,
                'tipo_tarea'  => 'SOLICITUD DE CONTRATACIONES DE INSTITUCIONES',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 8,
                'tipo_tarea'  => 'SOLICITUD DE CONTRATACIONES DE PERSONAL',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 9,
                'tipo_tarea'  => 'PROPUESTAS DE SERVICIOS COMERCIALES',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 10,
                'tipo_tarea'  => 'DOLICITUDES GENERALES DEL SISTEMA WEBPI',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 11,
                'tipo_tarea'  => 'NOTIFICACIONES',
                'descripcion' => null,
                'id_area' => '2',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 12,
                'tipo_tarea'  => 'CORRESPONDENCIA INTERNA',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 13,
                'tipo_tarea'  => 'CORRESPONDENCIA EXTERNA',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 14,
                'tipo_tarea'  => 'SALON VENEZUELA',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 15,
                'tipo_tarea'  => 'REUNIONES INTERINSTITUCIONALES',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 16,
                'tipo_tarea'  => 'MESA SUSTANTIVA',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],
            [
                'id'    => 17,
                'tipo_tarea'  => 'MESA ADMINISTRATIVA',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],
            [
                'id'    => 18,
                'tipo_tarea'  => 'MESA ASESORIA JURIDICA',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],
            [
                'id'    => 19,
                'tipo_tarea'  => 'CONVENIOS',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],
            [
                'id'    => 20,
                'tipo_tarea'  => 'PROYECTOS',
                'descripcion' => null,
                'id_area' => '1',
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ]
            ];

        $posts = $this->table('type_tasks');
        $posts->insert($data)
              ->saveData();
    }
}
