<?php

namespace App\Domain\Charge\Service;

use App\Domain\Charge\Repository\ChargeRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ChargeUpdater
{
    private ChargeRepository $repository;

    private ChargeValidator $areaValidator;

    private LoggerInterface $logger;

    public function __construct(
        ChargeRepository $repository,
        ChargeValidator $areaValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->areaValidator = $areaValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('area_updater.log')
            ->createLogger();
    }

    public function updateCharge(int $areaId, array $data): array
    {
        // Input validation
        $this->areaValidator->validateChargeUpdate($areaId, $data);

        // Update the row
        $values = $this->repository->updateCharge($areaId, $data);

        // Logging
        $this->logger->info(sprintf('Charge updated successfully: %s', $areaId));
        return $values;
    }
}
