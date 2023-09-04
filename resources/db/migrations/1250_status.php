<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Status extends AbstractMigration
{
    public function change(): void
    {
        $status = $this->table('status');
        $status   ->addColumn('state', 'string', ['limit' => 100])
                 
                  ->create();
    }
}
