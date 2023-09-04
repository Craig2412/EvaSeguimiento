<?php

namespace App\Domain\Charge\Service;

use App\Domain\Charge\Repository\ChargeRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class ChargeValidator
{
    private ChargeRepository $repository;

    public function __construct(ChargeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateChargeUpdate(int $chargeId, array $data): void
    {
        if (!$this->repository->existsChargeId($chargeId)) {
            throw new DomainException(sprintf('Charge not found: %s', $chargeId));
        }

        $this->validateCharge($data);
    }

    public function validateCharge(array $data): void
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
                'charge' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(7, 30),
                    ]
                )
            ]
        );
    }
}
