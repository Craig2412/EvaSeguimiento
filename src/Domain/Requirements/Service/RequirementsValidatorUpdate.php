<?php

namespace App\Domain\Requirements\Service;

use App\Domain\Requirements\Repository\RequirementsRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RequirementsValidatorUpdate
{
    private RequirementsRepository $repository;

    public function __construct(RequirementsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRequirementsUpdate(int $requirementsId, array $data): void
    {
        if (!$this->repository->existsRequirementsId($requirementsId)) {
            throw new DomainException(sprintf('Requirements not found: %s', $requirementsId));
        }

        $this->validateRequirements($data);
    }

    public function validateRequirements(array $data): void
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
