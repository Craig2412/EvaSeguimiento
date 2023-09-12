<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Data\NoteFileFinderItem;
use App\Domain\Note\Data\NoteFileFinderResult;
use App\Domain\Note\Repository\NoteFileFinderRepository;

final class NoteFileFinder
{
    private NoteFileFinderRepository $repository;

    public function __construct(NoteFileFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findNoteFile($noteId): NoteFileFinderResult
    {
        // Input validation
        $noteFile = $this->repository->findNoteFile($noteId);

        return $this->createResult($noteFile);
    }

    private function createResult(array $noteFileRows): NoteFileFinderResult
    {
        $result = new NoteFileFinderResult();

        foreach ($noteFileRows as $noteFileRow) {
            $noteFile = new NoteFileFinderItem();
           
            $noteFile->id = $noteFileRow['id'];
            $noteFile->nombre = $noteFileRow['nombre'];
            $noteFile->id_note = $noteFileRow['id_note'];
            $noteFile->src = $noteFileRow['src'];
            $noteFile->type_file = $noteFileRow['type_file'];

            $result->noteFile[] = $noteFile;
        }

        return $result;
    }
}
