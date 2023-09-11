<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelationNoteFiles extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('note_files');
        $table->addForeignKey(['id_note'],'users',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_noteNotes'])
              ->save();
    }
}
