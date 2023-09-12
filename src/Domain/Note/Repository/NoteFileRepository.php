<?php

namespace App\Domain\Note\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class NoteFileRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;

    }

    public function insertNoteFile(array $noteFile): int
    {
        return (int)$this->queryFactory->newInsert('note_files', $this->toRow($noteFile))
            ->execute()
            ->lastInsertId();
    }

    public function getNoteFileById(int $noteFileId): array
    {
        
        $query = $this->queryFactory->newSelect('note_files');
        $query->select(
            [
                'note_files.id',
                'note_files.nombre',
                'note_files.src',   
                'note_files.type_file',
                'note_files.id_note'
            ]
        );

        $query->where(['note_files.id' => $noteFileId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('NoteFile not found: %s', $noteFileId));
        }
        return $row;
    }

    
    public function existsNoteFileId(int $noteFileId): bool
    {
        $query = $this->queryFactory->newSelect('noteFiles');
        $query->select('id')->where(['id' => $noteFileId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteNoteFileById(int $noteFileId): void
    {
        $this->queryFactory->newDelete('note_files')
            ->where(['id' => $noteFileId])
            ->execute();
    }

    private function toRow(array $noteFile): array
    { 
        return [
            'nombre' => strtoupper($noteFile['nombre']),
            'type_file' => $noteFile['type_file'],
            'src' => $noteFile['src'],
            'id_note' => $noteFile['id_note'],
            'created' => $this->fecha
        ];
    }

   
}