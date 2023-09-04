<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Tasks extends AbstractMigration
{
    public function change(): void{
        
        $tasks = $this->table('tasks');
        $tasks->addColumn('title', 'string', ['limit' => 50])
                 ->addColumn('description', 'string' , ['limit' => 150])
                 ->addColumn('id_status', 'integer' , ['null' => false, 'signed' => false])
                 ->addColumn('id_area', 'integer' , ['null' => false, 'signed' => false])
                 ->addColumn('id_responsable', 'integer' , ['null' => false , 'signed' => false])
                 ->addColumn('id_type_task', 'integer' , ['null' => false, 'signed' => false])
                 ->addColumn('initial_date', 'datetime')
                 ->addColumn('estimated_date', 'datetime')
                 ->addColumn('due_date', 'datetime', ['null' => true])
                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])

                 ->addIndex('id_status')
                 ->addIndex('id_area')
                 ->addIndex('id_responsable')
                 ->addIndex('id_type_task')
                 
                  ->create();
    }
}
