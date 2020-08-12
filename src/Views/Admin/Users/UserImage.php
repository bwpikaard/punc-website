<?php

namespace App\Views\Admin\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFileInterface;
use Slim\Psr7\UploadedFile;

final class UserImage
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles["image"];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile(__DIR__ . "/../../../../public/images/{$body["location"]}", $uploadedFile, $args["id"]);
            return $response->withHeader("Location", "/admin/users/{$args["id"]}");
        } else {
            $response->getBody()->write("An error occured.");
            echo $uploadedFile->getError();
            return $response;
        }
        
        return $response->withHeader("Location", "/admin/users/{$args["id"]}");
    }
}

function moveUploadedFile($directory, UploadedFile $uploadedFile, $id)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

    $uploadedFile->moveTo("$directory/$id.png");

    return "no";
}
