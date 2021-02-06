<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \App\Database\Connection;

final class MeManage
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();

        if ($body["method"] == "PATCH") {
            $con = new Connection();

            $con->alter("UPDATE user SET firstname=?, lastname=?, email=?, website=?, institution=?, expertise=?, instrumentation=?, biography=? WHERE id=?", "ssssssssi", $body["firstname"], $body["lastname"], $body["email"], $body["website"], $body["institution"], $body["expertise"], $body["instrumentation"], $body["biography"], $_SESSION["user"]["id"]);

            $con->done();
            return $response->withHeader('Location', "/me");
        }

        return $response->withHeader('Location', "/me");
    }
}