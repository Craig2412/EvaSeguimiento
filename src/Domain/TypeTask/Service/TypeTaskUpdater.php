<?php

namespace App\Domain\TypeTask\Service;

use App\Domain\TypeTask\Repository\TypeTaskRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TypeTaskUpdater
{
    private TypeTaskRepository $repository;

    private TypeTaskValidator $typeTaskValidator;

    private LoggerInterface $logger;

    public function __construct(
        TypeTaskRepository $repository,
        TypeTaskValidator $typeTaskValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->typeTaskValidator = $typeTaskValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('typeTask_updater.log')
            ->createLogger();
    }

    public function updateTypeTask(int $typeTaskId, array $data): array
    {
        // Input validation
        $this->typeTaskValidator->validateTypeTaskUpdate($typeTaskId, $data);

        // Update the row
        $values = $this->repository->updateTypeTask($typeTaskId, $data);

        // Logging
        $this->logger->info(sprintf('TypeTask updated successfully: %s', $typeTaskId));
        return $values;
    }
}
