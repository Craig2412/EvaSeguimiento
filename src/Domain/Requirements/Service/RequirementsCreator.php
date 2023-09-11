<?php

namespace App\Domain\Requirements\Service;

use App\Domain\Requirements\Repository\RequirementsRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RequirementsCreator
{
    private RequirementsRepository $repository;

    private RequirementsValidator $requirementsValidator;

    private LoggerInterface $logger;

    public function __construct(
        RequirementsRepository $repository,
        RequirementsValidator $requirementsValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->requirementsValidator = $requirementsValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('requirements_creator.log')
            ->createLogger();
    }

    public function createRequirements(array $data): int
    {
        // Input validation
            $this->requirementsValidator->validateRequirements($data);
        
        // Insert requirements and get new requirements ID
            $requirementsId = $this->repository->insertRequirements($data);

        // Logging
        $this->logger->info(sprintf('Requirements created successfully: %s', $requirementsId));

        return $requirementsId;
    }
}
