<?php

namespace App\Domain\Area\Service;

use App\Domain\Area\Repository\AreaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class AreaCreator
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
            ->addFileHandler('area_creator.log')
            ->createLogger();
    }

    public function createArea(array $data): int
    {
        // Input validation
        $this->areaValidator->validateArea($data);

        // Insert area and get new area ID
        $areaId = $this->repository->insertArea($data);

        // Logging
        $this->logger->info(sprintf('Area created successfully: %s', $areaId));

        return $areaId;
    }
}
