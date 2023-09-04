<?php

namespace App\Domain\TypeTask\Service;

use App\Domain\TypeTask\Repository\TypeTaskRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class TypeTaskValidator
{
    private TypeTaskRepository $repository;

    public function __construct(TypeTaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateTypeTaskUpdate(int $typeTaskId, array $data): void
    {
        if (!$this->repository->existsTypeTaskId($typeTaskId)) {
            throw new DomainException(sprintf('TypeTask not found: %s', $typeTaskId));
        }

        $this->validateTypeTask($data);
    }

    public function validateTypeTask(array $data): void
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
                'tipo_tarea' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30),
                    ]
                ),
                'descripcion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 100),
                    ]
                ),
                'id_area' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                    ]
                ),
                'updated' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,19),
                    ]
                )
            ]
        );
    }
}
