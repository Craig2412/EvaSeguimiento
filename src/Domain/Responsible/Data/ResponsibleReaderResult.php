<?php

namespace App\Domain\Responsible\Data;

/**
 * DTO.
 */
final class ResponsibleReaderResult
{
    public ?int $id = null;

    public ?string $nombre = null;
    
    public ?string $direccion = null;
    
    public ?string $gmail = null;
    
    public ?string $id_charge = null;
    public ?string $charge = null;
    
    public ?string $created = null;
    public ?string $updated = null;
}
