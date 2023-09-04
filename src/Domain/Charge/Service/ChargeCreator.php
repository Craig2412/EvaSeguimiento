<?php

namespace App\Domain\Charge\Service;

use App\Domain\Charge\Repository\ChargeRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ChargeCreator
{
    private ChargeRepository $repository;

    private ChargeValidator $chargeValidator;

    private LoggerInterface $logger;

    public function __construct(
        ChargeRepository $repository,
        ChargeValidator $chargeValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->chargeValidator = $chargeValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('charge_creator.log')
            ->createLogger();
    }

    public function createCharge(array $data): int
    {
        // Input validation
        $this->chargeValidator->validateCharge($data);

        // Insert charge and get new charge ID
        $chargeId = $this->repository->insertCharge($data);

        // Logging
        $this->logger->info(sprintf('Charge created successfully: %s', $chargeId));

        return $chargeId;
    }
}
