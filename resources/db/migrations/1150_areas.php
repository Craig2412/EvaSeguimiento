<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Areas extends AbstractMigration
{
    public function change(): void{
        
        $areas = $this->table('areas');
        $areas   ->addColumn('area', 'string', ['limit' => 30])
                 ->addColumn('descripcion', 'string' , ['limit' => 100])
                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])
                 
                 ->addIndex('area' , ['unique' => true])

                 ->create();
    }
}
