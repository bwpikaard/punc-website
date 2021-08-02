<?php

namespace App\Views\Admin\Pages\Rows;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Row
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        if ($request->getMethod() == "GET") {
            $view = Twig::fromRequest($request);

            $con = new Connection();

            $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();
            $row = $con->select_where("SELECT * FROM `row` WHERE id=?", "i", $args["rowid"])->fetch_assoc();

            $con->done();

            return $view->render($response, 'admin/pages/rows/row.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath(),
                "page" => $page,
                "row" => $row,
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();
            $con = new Connection();

            $con->alter("UPDATE `row` SET `order`=? WHERE id=?", "ii", $body["order"], $args["id"]);

            $con->done();

            return $response->withHeader("Location", "/admin/pages/{$args["id"]}/rows/{$args["rowid"]}");
        }
    }
}