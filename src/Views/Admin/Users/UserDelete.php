<?php

namespace App\Views\Admin\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class UserDelete
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $con->alter("DELETE FROM user WHERE id=?", "i", $args["id"]);

        $con->done();
        
        return $response->withHeader("Location", "/admin/users");
    }
}