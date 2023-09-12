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
         // Extract the form data from the request body
         $data = (array)$request->getParsedBody();
        
        $archivo = $data["src"];

        
        if (file_exists($archivo)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($archivo).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            readfile($archivo);
            exit;
        } else {
            return $this->renderer
            ->json($response, ['message' => 'Error al descargar el archivo'], StatusCodeInterface::STATUS_BAD_REQUEST);
        }
        
        
                // Build the HTTP response
                return $this->renderer
                    ->json($response, ['noteFile_id' => $noteFileId])
                    ->withStatus(StatusCodeInterface::STATUS_CREATED);

           
                       
    }
}
