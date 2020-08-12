<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFile;

final class MeImage
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles["image"];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile(__DIR__ . "/../../public/images/{$body["location"]}", $uploadedFile, $_SESSION["user"]["id"]);
            return $response->withHeader("Location", "/me");
        } else {
            $response->getBody()->write("An error occured.");
            echo $uploadedFile->getError();
            return $response;
        }
        
        return $response->withHeader("Location", "/me");
    }
}

function moveUploadedFile($directory, UploadedFile $uploadedFile, $id)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

    $uploadedFile->moveTo("$directory/$id.png");

    return "no";
}
