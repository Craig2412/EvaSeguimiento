<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NotesFiles extends AbstractMigration
{
    public function change(): void
    {
        $noteFiles = $this->table('note_files');
        $noteFiles ->addColumn('nombre', 'string', ['limit' => 100])
                    ->addColumn('type_file', 'string', ['limit' => 50])
                    ->addColumn('src', 'string', ['limit' => 300])
                    ->addColumn('id_note', 'integer' , ['null' => false , 'signed' => false])
                    ->addColumn('created', 'datetime')

                    ->addIndex('id_note')
                                
                    ->create();
    }
}
