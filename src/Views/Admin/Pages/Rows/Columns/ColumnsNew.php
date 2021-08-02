<?php

namespace App\Views\Admin\Pages\Rows\Columns;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class ColumnsNew
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();

        $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();
        $row = $con->select_where("SELECT * FROM `row` WHERE id=?", "i", $args["rowid"])->fetch_assoc();

        $con->done();

        if (is_null($page)) return $response->withHeader("Location", "/admin/pages");
        if (is_null($row)) return $response->withHeader("Location", "/admin/pages/{$page["id"]}");

        if ($request->getMethod() == "GET") {
            return $view->render($response, 'admin/pages/rows/columns/column.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath(),
                "page" => $page,
                "row" => $row,
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();

            $con = new Connection();

            $req = $con->alter(
                "INSERT INTO `column` (`row_id`, `order`, `body`) VALUES (?, ?, ?)",
                "iis",
                $row["id"],
                $body["order"],
                $body["body"]
            );

            $con->done();

            return $response->withHeader("Location", "/admin/pages/{$page["id"]}/rows/{$row["id"]}/columns");
        }
    }
}
