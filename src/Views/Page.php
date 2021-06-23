<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Page
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();

        $page = $con->select_where("SELECT * FROM page WHERE slug=?", "s", $args["slug"])->fetch_assoc();

        if (is_null($page)) return $response->withHeader("Location", "/");

        return $view->render($response, 'page.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "page" => $page
        ]);
    }
}