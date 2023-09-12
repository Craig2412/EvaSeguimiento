<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Notes extends AbstractMigration
{
    public function change(): void{
        
        $notes = $this->table('notes');
        $notes->addColumn('note', 'string', ['limit' => 300])
                 ->addColumn('id_user', 'integer' , ['null' => false , 'signed' => false])
                 ->addColumn('id_task', 'integer' , ['null' => false , 'signed' => false])
                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])

                 ->addIndex('id_user')
                 ->addIndex('id_task')
                 
                 ->create();
    }
}
