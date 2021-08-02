<?php

namespace App\Views\Admin\Pages\Rows\Columns;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Column
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        if ($request->getMethod() == "GET") {
            $view = Twig::fromRequest($request);

            $con = new Connection();

            $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();
            $row = $con->select_where("SELECT * FROM `row` WHERE id=?", "i", $args["rowid"])->fetch_assoc();
            $column = $con->select_where("SELECT * FROM `column` WHERE id=?", "i", $args["columnid"])->fetch_assoc();

            $con->done();

            return $view->render($response, 'admin/pages/rows/columns/column.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath(),
                "page" => $page,
                "row" => $row,
                "column" => $column
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();
            $con = new Connection();

            $con->alter("UPDATE `column` SET `order`=?, `body`=? WHERE id=?", "isi", $body["order"], $body["body"], $args["columnid"]);

            $con->done();

            return $response->withHeader("Location", "/admin/pages/{$args["id"]}/rows/{$args["rowid"]}/columns/{$args["columnid"]}");
        }
    }
}