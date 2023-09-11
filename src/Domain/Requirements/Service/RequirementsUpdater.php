<?php

namespace App\Domain\Requirements\Service;

use App\Domain\Requirements\Repository\RequirementsRepositoryUpdate;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RequirementsUpdater
{
    private RequirementsRepositoryUpdate $repositoryUpdate;

    private RequirementsValidatorUpdate $requirementsValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        RequirementsRepositoryUpdate $repositoryUpdate,
        RequirementsValidatorUpdate $requirementsValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repositoryUpdate = $repositoryUpdate;
        $this->requirementsValidatorUpdate = $requirementsValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('requirements_updater.log')
            ->createLogger();
    }

    public function updateRequirements(int $requirementsId, array $data): array
    {
        // Input validation
        $this->requirementsValidatorUpdate->validateRequirementsUpdate($requirementsId, $data);

        // Update the row
        $var = $this->repositoryUpdate->updateRequirements($requirementsId, $data);
        

        // Logging
        $this->logger->info(sprintf('Requirements updated successfully: %s', $requirementsId));

        return $var;
    }
}
