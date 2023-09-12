<?php

namespace App\Domain\Note\Repository;

use App\Factory\QueryFactory;

final class NoteFileFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findNoteFile($noteId): array
    {
        //Paginador
        $limit = $cant_registros;
        $offset = ($nro_pag - 1) * $limit;
        $query = $this->queryFactory->newSelect('note_files');
        //Fin Paginador
        
        $query->select(
            [
                'note_files.id',
                'note_files.nombre',
                'note_files.src',   
                'note_files.type_file',
                'note_files.id_note'
            ]
        );

        $query->where(['note_files.id_note' => $noteId]);    

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
