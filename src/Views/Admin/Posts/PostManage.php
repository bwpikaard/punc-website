<?php

namespace App\Views\Admin\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class PostManage
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $body = $request->getParsedBody();

        if ($body["method"] == "POST") {
            $con = new Connection();
            $date = date("Y-m-d H:i:s");

            $con->alter("UPDATE posts SET title=?, content=? WHERE id=?", "ssi", $body["title"], $body["content"], $args["id"]);
            
            $req = $con->alter("INSERT INTO posts (published, author, title, content, created) VALUES (0, ?, ?, ?, '$date')", "iss", $_SESSION["user"]["id"], $body["title"], $body["content"]);

            $con->done();

            return $response->withHeader("Location", "/admin/posts/{$req->insert_id}");
        } else if ($body["method"] == "PATCH") {
            $con = new Connection();

            $con->alter("UPDATE post SET title=?, body=? WHERE id=?", "ssi", $body["title"], $body["content"], $args["id"]);

            $con->done();

            return $response->withHeader("Location", "/admin/posts/{$args["id"]}");
        }

        return $response->withHeader("Location", "/admin/posts");
    }
}