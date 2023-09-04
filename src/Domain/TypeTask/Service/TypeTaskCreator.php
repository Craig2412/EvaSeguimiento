<?php

namespace App\Domain\TypeTask\Service;

use App\Domain\TypeTask\Repository\TypeTaskRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TypeTaskCreator
{
    private TypeTaskRepository $repository;

    private TypeTaskValidator $TypeTaskValidator;

    private LoggerInterface $logger;

    public function __construct(
        TypeTaskRepository $repository,
        TypeTaskValidator $TypeTaskValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->TypeTaskValidator = $TypeTaskValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('TypeTask_creator.log')
            ->createLogger();
    }

    public function createTypeTask(array $data): int
    {
        // Input validation
        $this->TypeTaskValidator->validateTypeTask($data);

        // Insert TypeTask and get new TypeTask ID
        $TypeTaskId = $this->repository->insertTypeTask($data);

        // Logging
        $this->logger->info(sprintf('TypeTask created successfully: %s', $TypeTaskId));

        return $TypeTaskId;
    }
}
