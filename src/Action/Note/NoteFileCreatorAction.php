<?php

namespace App\Action\Note;

use App\Domain\Note\Service\NoteFileCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

function guardarArchivo($archivo) {
    $rutaDestino = __DIR__.'/./../../../resources/notesFiles/';
    $nombreArchivo = uniqid() . '_' . $archivo['name'];
    $rutaCompleta = $rutaDestino . $nombreArchivo;
    $tipoArchivo = $_FILES['file']['type'];

    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        return [
                "nombre" => $nombreArchivo,
                "src" => $rutaCompleta, 
                "type_file" => $tipoArchivo
               ];
    } else {
        return false;
    }
}

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
         // Extract the form data from the request body
         $data = (array)$request->getParsedBody();

         if (isset($_FILES['file'])) {
            $archivo = $_FILES['file'];
            $resultado = guardarArchivo($archivo);
            if ($resultado !== false) {
                $data["nombre"] = $resultado["nombre"];
                $data["type_file"] = $resultado["type_file"];
                $data["src"] = $resultado["src"];
                 // Invoke the Domain with inputs and retain the result
                $noteFileId = $this->noteFileCreator->createNoteFile($data);
        
                // Build the HTTP response
                return $this->renderer
                    ->json($response, ['noteFile_id' => $noteFileId])
                    ->withStatus(StatusCodeInterface::STATUS_CREATED);

            } else {
                return $this->renderer
                        ->json($response, ['message' => 'Error al subir el archivo'], StatusCodeInterface::STATUS_BAD_REQUEST);
            }
        }                
    }
}
