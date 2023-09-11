<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Notes extends AbstractMigration
{
    public function change(): void{
        
        $notes = $this->table('notesFile');
        $notes->addColumn('name', 'string', ['limit' => 100])
                 ->addColumn('type_file', 'string', ['limit' => 100])
                 ->addColumn('id_task', 'integer' , ['null' => false , 'signed' => false])
                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])

                 ->addIndex('id_user')
                 ->addIndex('id_task')
                 
                 ->create();
    }
}
