<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Charges extends AbstractMigration
{
    public function change(): void
    {
        $charges = $this->table('charges');
        $charges   ->addColumn('charge', 'string', ['limit' => 30])
                 ->create();
    }
}
