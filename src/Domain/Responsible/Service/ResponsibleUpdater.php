<?php

namespace App\Domain\Responsible\Service;

use App\Domain\Responsible\Repository\ResponsibleRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ResponsibleUpdater
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
            ->addFileHandler('responsible_updater.log')
            ->createLogger();
    }

    public function updateResponsible(int $responsibleId, array $data): array
    {
        // Input validation
        $this->responsibleValidator->validateResponsibleUpdate($responsibleId, $data);

        // Update the row
        $values = $this->repository->updateResponsible($responsibleId, $data);

        // Logging
        $this->logger->info(sprintf('Responsible updated successfully: %s', $responsibleId));
        return $values;
    }
}
