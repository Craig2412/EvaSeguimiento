<?php


use Phinx\Seed\AbstractSeed;

class Charges extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'charge'    => 'DIRECTOR'
            ],[
                'id'    => 2,
                'charge'    => 'COORDINADOR'
            ],[
                'id'    => 3,
                'charge'    => 'JEFE DE DIVISION'
            ]
            ];

        $posts = $this->table('charges');
        $posts->insert($data)
              ->saveData();
    }
}
