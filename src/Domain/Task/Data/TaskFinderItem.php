<?php

namespace App\Domain\Task\Data;

final class TaskFinderItem
{
    public ?int $id = null;

    public ?string $title = null;

    public ?string $description = null;

    public ?int $id_status = null;
    public ?string $status = null;
    
    public ?int $id_area = null;
    public ?string $area = null;
    
    public ?int $id_responsable = null;
    public ?string $nombre = null;
    public ?string $direccion = null;

    public ?int $id_type_task = null;
    public ?string $type_task = null;
    
    public ?string $initial_date = null;
    public ?string $estimated_date = null;
    public ?string $due_date = null;

    public ?string $created = null;

    public ?string $updated = null;
}
