<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Responsible extends AbstractMigration
{
    public function change(): void
    {
        $responsibles = $this->table('responsibles');
        $responsibles   ->addColumn('nombre', 'string', ['limit' => 100])
                        ->addColumn('direccion', 'string', ['limit' => 40])
                        ->addColumn('gmail', 'string' , ['limit' => 15])
                        ->addColumn('id_charge','integer' , ['null' => false, 'signed' => false, 'default'=> 1])

                        ->addColumn('created', 'datetime')
                        ->addColumn('updated', 'datetime', ['null' => true])

                        ->addIndex('id_charge')
                        ->addIndex('gmail', ['unique' => true])
                        ->create();
    }
}
