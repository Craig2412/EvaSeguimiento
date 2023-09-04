<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelationResponsibles extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('responsibles');
        $table->addForeignKey(['id_charge'],'charges',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_chargeResponsibles'])
              ->save();
    }
}
