<?php

namespace App\Views\Admin\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Posts
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $posts = $con->select("SELECT posts.*, users.firstname AS author_firstname, users.lastname AS author_lastname FROM posts LEFT JOIN users ON posts.author = users.id");

        $con->done();
        
        return $view->render($response, 'admin/posts/posts.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "posts" => $posts
        ]);
    }
}