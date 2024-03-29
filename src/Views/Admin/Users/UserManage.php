<?php

namespace App\Views\Admin\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class UserManage
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();

        if ($body["method"] == "PATCH") {
            $con = new Connection();

            $con->alter("UPDATE user SET permission_level=?, hidden=?, firstname=?, lastname=?, username=?, email=?, website=?, institution=?, expertise=?, instrumentation=?, biography=? WHERE id=?", "iisssssssssi", $body["permission_level"], $body["hidden"], $body["firstname"], $body["lastname"], $body["username"], $body["email"], $body["website"], $body["institution"], $body["expertise"], $body["instrumentation"], $body["biography"], $body["id"]);

            $con->done();

            return $response->withHeader('Location', "/admin/users/{$body["id"]}");
        }

        return $response->withHeader('Location', "/admin/users");
    }
}