<?php

namespace App\Domain\Status\Service;

use App\Domain\Status\Repository\StatusRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class StatusValidator
{
    private StatusRepository $repository;

    public function __construct(StatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateStatusUpdate(int $statusId, array $data): void
    {
        if (!$this->repository->existsStatusId($statusId)) {
            throw new DomainException(sprintf('Status not found: %s', $statusId));
        }

        $this->validateStatus($data);
    }

    public function validateStatus(array $data): void
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
                'state' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30),
                    ]
                )
            ]
        );
    }
}
