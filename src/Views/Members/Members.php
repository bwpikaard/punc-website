<?php

namespace App\Views\Members;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Members
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $users = $con->select("SELECT * FROM user WHERE permission_level > 0 AND hidden != 1");

        $con->done();

        return $view->render($response, 'members/members.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "users" => $users
        ]);
    }
}