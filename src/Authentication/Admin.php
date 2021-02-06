<?php

namespace App\Authentication;

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class Admin
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if (isset($_SESSION["user"])) {
            if ($_SESSION["user"]["permission_level"] < 3) {
                return $response->withStatus(403)->withHeader("Location", "/");
            }
        } else {
            $_SESSION["redirect"] = $request->getUri()->getPath();

            return $response->withStatus(401)->withHeader("Location", "/auth/login");
        }

        return $response;
    }
}