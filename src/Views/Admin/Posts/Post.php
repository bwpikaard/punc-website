<?php

namespace App\Views\Admin\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Post
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        if ($args["id"] == "new") {
            return $view->render($response, 'admin/posts/post.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath()
            ]);
        } else {
            $con = new Connection();
        
            $post = $con->select_where("SELECT * FROM posts WHERE id=?", "i", $args["id"])->fetch_assoc();

            $con->done();

            if (empty($post)) return $response->withHeader("Location", "/admin/posts");
            
            return $view->render($response, 'admin/posts/post.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath(),
                "post" => $post
            ]);
        }
    }
}