<?php

namespace App\Domain\Area\Service;

use App\Domain\Area\Repository\AreaRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class AreaValidator
{
    private AreaRepository $repository;

    public function __construct(AreaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateAreaUpdate(int $areaId, array $data): void
    {
        if (!$this->repository->existsAreaId($areaId)) {
            throw new DomainException(sprintf('Area not found: %s', $areaId));
        }

        $this->validateArea($data);
    }

    public function validateArea(array $data): void
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
                'area' => $constraint->required(
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
                'updated' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,19)
                    ]
                )
            ]
        );
    }
}
