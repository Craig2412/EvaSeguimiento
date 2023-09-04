<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Repository\TaskRepositoryUpdate;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TaskUpdater
{
    private TaskRepositoryUpdate $repositoryUpdate;

    private TaskValidatorUpdate $taskValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        TaskRepositoryUpdate $repositoryUpdate,
        TaskValidatorUpdate $taskValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repositoryUpdate = $repositoryUpdate;
        $this->taskValidatorUpdate = $taskValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('task_updater.log')
            ->createLogger();
    }

    public function updateTask(int $taskId, array $data): array
    {
        // Input validation
        $this->taskValidatorUpdate->validateTaskUpdate($taskId, $data);

        // Update the row
        $var = $this->repositoryUpdate->updateTask($taskId, $data);
        

        // Logging
        $this->logger->info(sprintf('Task updated successfully: %s', $taskId));

        return $var;
    }
}
