<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Home
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();

        $config = $con->select("SELECT * FROM configuration");

        $config = array_reduce($config, function($result, $item) {
            $result[$item["key"]] = $item["value"];

            return $result;
        }, array());

        $posts = $con->select("SELECT posts.*, users.firstname AS author_firstname, users.lastname AS author_lastname FROM posts LEFT JOIN users ON posts.author = users.id WHERE posts.published = 1");

        $con->done;

        return $view->render($response, 'home.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "configuration" => $config,
            "posts" => $posts
        ]);
    }
}