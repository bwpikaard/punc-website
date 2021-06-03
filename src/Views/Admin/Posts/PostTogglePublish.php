<?php

namespace App\Views\Admin\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class PostTogglePublish
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $body = $request->getParsedBody();

        $con = new Connection();
        
        $post = $con->select_where("SELECT * FROM post WHERE id=?", "i", $args["id"])->fetch_assoc();

        if (empty($post)) return $response->withHeader('Location', "/admin/posts");

        if ($post["published"]) {
            $con->alter("UPDATE post SET published=0 WHERE id=?", "i", $args["id"]);
        } else {
            $con->alter("UPDATE post SET published=1 WHERE id=?", "i", $args["id"]);
        }

        $con->done();

        return $response->withHeader('Location', "/admin/posts");
    }
}