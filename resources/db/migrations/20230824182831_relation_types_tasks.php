<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelationTypesTasks extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('type_tasks');
        $table->addForeignKey(['id_area'],'areas',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_areaType'])
                        ->save();
    }
}
