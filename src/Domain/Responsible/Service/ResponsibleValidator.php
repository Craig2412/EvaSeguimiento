<?php

namespace App\Domain\Responsible\Service;

use App\Domain\Responsible\Repository\ResponsibleRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class ResponsibleValidator
{
    private ResponsibleRepository $repository;

    public function __construct(ResponsibleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateResponsibleUpdate(int $responsibleId, array $data): void
    {
        if (!$this->repository->existsResponsibleId($responsibleId)) {
            throw new DomainException(sprintf('Responsible not found: %s', $responsibleId));
        }

        $this->validateResponsible($data);
    }

    public function validateResponsible(array $data): void
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
                'nombre' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,100),
                    ]),
                'direccion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(7, 50)
                    ]),
                'gmail' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(7, 50)
                    ]
                ),
                'id_charge' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,2),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
