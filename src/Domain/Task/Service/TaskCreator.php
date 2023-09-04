<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Repository\TaskRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TaskCreator
{
    private TaskRepository $repository;

    private TaskValidator $taskValidator;

    private LoggerInterface $logger;

    public function __construct(
        TaskRepository $repository,
        TaskValidator $taskValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->taskValidator = $taskValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('task_creator.log')
            ->createLogger();
    }

    public function createTask(array $data): int
    {
        // Input validation
            $this->taskValidator->validateTask($data);
        
        // Insert task and get new task ID
            $taskId = $this->repository->insertTask($data);

        // Logging
        $this->logger->info(sprintf('Task created successfully: %s', $taskId));

        return $taskId;
    }
}
