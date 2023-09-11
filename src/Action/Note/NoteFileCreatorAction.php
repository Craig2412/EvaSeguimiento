<?php

namespace App\Action\Note;

use App\Domain\Note\Service\NoteFileCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteFileCreatorAction
{
    private JsonRenderer $renderer;

    private NoteFileCreator $noteFileCreator;

    public function __construct(NoteFileCreator $noteFileCreator, JsonRenderer $renderer)
    {
        $this->noteFileCreator = $noteFileCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Obtiene el archivo de la solicitud
        $uploadedFile = $request->getUploadedFiles()['file'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            // Genera un nombre único para el archivo
            var_dump('holi');
            $filename = uniqid() . '_' . $uploadedFile->getClientFilename();
            
            // Mueve el archivo a la carpeta de destino
            $uploadedFile->moveTo('../../resources/notesFiles/' . $filename);

            // Construye la respuesta HTTP
            return $this->renderer
                ->json($response, ['message' => 'Archivo guardado correctamente'])
                ->withStatus(StatusCodeInterface::STATUS_CREATED);
        } else {
            // En caso de error al subir el archivo
            return $this->renderer
                ->json($response, ['message' => 'Error al subir el archivo'], StatusCodeInterface::STATUS_BAD_REQUEST);
        }
    }
}
