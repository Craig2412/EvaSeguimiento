<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelationNotes extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('notes');
        $table->addForeignKey(['id_user'],'users',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_userType'])
              ->addForeignKey(['id_task'],'tasks',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_taskType'])
              ->save();
    }
}
