<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Repository\NoteFileRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class NoteFileValidator
{
    private NoteFileRepository $repository;

    public function __construct(NoteFileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateNoteFileUpdate(int $noteFileId, array $data): void
    {
        if (!$this->repository->existsNoteFileId($noteFileId)) {
            throw new DomainException(sprintf('NoteFile not found: %s', $noteFileId));
        }

        $this->validateNoteFile($data);
    }

    public function validateNoteFile(array $data): void
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
                'type_file' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,50),
                        $constraint->positive()
                    ]),
                'src' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,300),
                        $constraint->positive()
                    ]
                ),
                'id_note' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
