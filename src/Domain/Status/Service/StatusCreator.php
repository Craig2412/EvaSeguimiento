<?php

namespace App\Domain\Status\Service;

use App\Domain\Status\Repository\StatusRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class StatusCreator
{
    private StatusRepository $repository;

    private StatusValidator $statusValidator;

    private LoggerInterface $logger;

    public function __construct(
        StatusRepository $repository,
        StatusValidator $statusValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->statusValidator = $statusValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('status_creator.log')
            ->createLogger();
    }

    public function createStatus(array $data): int
    {
        // Input validation
        $this->statusValidator->validateStatus($data);

        // Insert status and get new status ID
        $statusId = $this->repository->insertStatus($data);

        // Logging
        $this->logger->info(sprintf('Status created successfully: %s', $statusId));

        return $statusId;
    }
}
