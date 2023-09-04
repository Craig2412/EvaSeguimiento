<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TypeTask extends AbstractMigration
{
    public function change(): void{
        
        $type_tasks = $this->table('type_tasks');
        $type_tasks->addColumn('tipo_tarea', 'string', ['limit' => 100])
                 ->addColumn('descripcion', 'string' , ['limit' => 100])
                 ->addColumn('id_area', 'integer' , ['null' => false , 'signed' => false])
                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])

                 ->addIndex('id_area')
                 
                 ->create();
    }
}
