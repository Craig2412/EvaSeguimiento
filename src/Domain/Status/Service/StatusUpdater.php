<?php

namespace App\Domain\Status\Service;

use App\Domain\Status\Repository\StatusRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class StatusUpdater
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
            ->addFileHandler('status_updater.log')
            ->createLogger();
    }

    public function updateStatus(int $statusId, array $data): array
    {
        // Input validation
        $this->statusValidator->validateStatusUpdate($statusId, $data);

        // Update the row
        $values = $this->repository->updateStatus($statusId, $data);

        // Logging
        $this->logger->info(sprintf('Status updated successfully: %s', $statusId));
        return $values;
    }
}
