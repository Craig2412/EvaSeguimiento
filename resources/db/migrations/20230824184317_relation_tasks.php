<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelationTasks extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tasks');
        $table->addForeignKey(['id_status'],'status',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_statusTasks'])
              ->addForeignKey(['id_area'],'areas',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_areaTasks'])
              ->addForeignKey(['id_type_task'],'type_tasks',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_type_taskTasks'])
              ->addForeignKey(['id_responsable'],'responsibles',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_responsableTasks'])
              
              ->save();
    }
}
