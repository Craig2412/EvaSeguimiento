<?php

namespace App\Domain\Requirements\Data;

final class RequirementsReaderResult
{
    public ?int $id = null;

    public ?int $amount_request = null;

    public ?string $format_appointment = null;

    public ?string $name = null;//worker

    public ?string $surname = null;//worker

    public ?string $condition = null;

    public ?string $status = null;

    public ?string $created = null;

    public ?string $updated = null;

}