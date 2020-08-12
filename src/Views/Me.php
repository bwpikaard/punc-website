<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Me
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $user = $con->select_where("SELECT * FROM users WHERE id=?", "i", $_SESSION["user"]["id"])->fetch_assoc();

        $con->done();

        return $view->render($response, 'me.twig', [
            "user" => $user,
            "path" => $request->getUri()->getPath()
        ]);
    }
}