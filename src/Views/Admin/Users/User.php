<?php

namespace App\Views\Admin\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class User
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $user = $con->select_where("SELECT * FROM user WHERE id=?", "i", $args["id"])->fetch_assoc();

        if (empty($user)) return $response->withHeader("Location", "/admin/users");

        $con->done();
        
        return $view->render($response, 'admin/users/user.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "nuser" => $user
        ]);
    }
}