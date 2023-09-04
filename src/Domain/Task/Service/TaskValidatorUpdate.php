<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Repository\TaskRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class TaskValidatorUpdate
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateTaskUpdate(int $taskId, array $data): void
    {
        if (!$this->repository->existsTaskId($taskId)) {
            throw new DomainException(sprintf('Task not found: %s', $taskId));
        }

        $this->validateTask($data);
    }

    public function validateTask(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'id_status' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,1),
                    ]
                )
            ]
        );
    }
}
