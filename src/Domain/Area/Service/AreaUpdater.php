<?php

namespace App\Domain\Area\Service;

use App\Domain\Area\Repository\AreaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class AreaUpdater
{
    private AreaRepository $repository;

    private AreaValidator $areaValidator;

    private LoggerInterface $logger;

    public function __construct(
        AreaRepository $repository,
        AreaValidator $areaValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->areaValidator = $areaValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('area_updater.log')
            ->createLogger();
    }

    public function updateArea(int $areaId, array $data): array
    {
        // Input validation
        $this->areaValidator->validateAreaUpdate($areaId, $data);

        // Update the row
        $values = $this->repository->updateArea($areaId, $data);

        // Logging
        $this->logger->info(sprintf('Area updated successfully: %s', $areaId));
        return $values;
    }
}
