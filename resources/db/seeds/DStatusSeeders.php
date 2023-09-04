<?php


use Phinx\Seed\AbstractSeed;

class DStatusSeeders extends AbstractSeed
{
    
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'state'  => 'POR INICIAR'
            ],[
                'id'    => 2,
                'state'  => 'EN PROCESO'
            ],[
                'id'    => 3,
                'state'  => 'CULMINADO'
            ],[
                'id'    => 4,
                'state'  => 'DETENIDO'
            ]
            ];

        $posts = $this->table('status');
        $posts->insert($data)
              ->saveData();
    }
}
