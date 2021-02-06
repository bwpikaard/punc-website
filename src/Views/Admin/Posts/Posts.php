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
        
        $posts = $con->select("SELECT post.*, user.firstname AS author_firstname, user.lastname AS author_lastname FROM post LEFT JOIN user ON post.author = user.id");

        $con->done();
        
        return $view->render($response, 'admin/posts/posts.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "posts" => $posts
        ]);
    }
}