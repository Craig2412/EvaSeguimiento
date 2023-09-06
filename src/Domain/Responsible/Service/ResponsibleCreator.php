<?php

namespace App\Domain\Responsible\Service;

use App\Domain\Responsible\Repository\ResponsibleRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ResponsibleCreator
{
    private ResponsibleRepository $repository;

    private ResponsibleValidator $responsibleValidator;

    private LoggerInterface $logger;

    public function __construct(
        ResponsibleRepository $repository,
        ResponsibleValidator $responsibleValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->responsibleValidator = $responsibleValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('responsible_creator.log')
            ->createLogger();
    }

    public function createResponsible(array $data): int
    {
        // Input validation
            $this->responsibleValidator->validateResponsible($data);
        
        // Insert responsible and get new responsible ID
            $responsibleId = $this->repository->insertResponsible($data);

        // Logging
        $this->logger->info(sprintf('Responsible created successfully: %s', $responsibleId));

        return $responsibleId;
    }
}
