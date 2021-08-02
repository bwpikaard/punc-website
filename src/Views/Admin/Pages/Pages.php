<?php

namespace App\Views\Admin\Pages;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Pages
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $pages = $con->select("SELECT * FROM page");

        $con->done();
        
        return $view->render($response, 'admin/pages/pages.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "pages" => $pages
        ]);
    }
}