<?php

namespace App\Views\Admin\Pages\Rows\Columns;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Columns
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();
        $row = $con->select_where("SELECT * FROM `row` WHERE id=?", "i", $args["rowid"])->fetch_assoc();
        $columns = $con->select_where("SELECT * FROM `column` WHERE `row_id`=?", "i", $args["rowid"]);

        $con->done();
        
        return $view->render($response, 'admin/pages/rows/columns/columns.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "page" => $page,
            "row" => $row,
            "columns" => $columns
        ]);
    }
}