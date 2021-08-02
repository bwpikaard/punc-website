<?php

namespace App\Views\Admin\Pages\Rows;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Rows
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();
        $rows = $con->select_where("SELECT * FROM `row` WHERE page_id=?", "i", $args["id"]);

        $con->done();
        
        return $view->render($response, 'admin/pages/rows/rows.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "page" => $page,
            "rows" => $rows
        ]);
    }
}