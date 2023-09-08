<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Repository\TaskRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class TaskValidator
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
                'title' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,50),
                    ]),
                'description' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 150)
                    ]),
                'id_status' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1),
                        $constraint->positive()
                    ]
                ),
                'id_area' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1),
                        $constraint->positive()
                    ]
                ),
                'id_responsable' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,3),
                        $constraint->positive()
                    ]
                ),
                'id_type_task' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,3),
                        $constraint->positive()
                    ]                
                ),
                'initial_date' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,19)
                    ]                
                ),
                'estimated_date' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,19)
                    ]                
                ),
                'due_date' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,19),
                    ]                
                )
            ]
        );
    }
}
