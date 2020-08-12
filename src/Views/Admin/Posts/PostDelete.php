<?php

namespace App\Views\Admin\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class PostDelete
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $con = new Connection();

        $con->alter("DELETE FROM posts WHERE id=?", "i", $args["id"]);

        $con->done();

        return $response->withHeader("Location", "/admin/posts");
    }
}