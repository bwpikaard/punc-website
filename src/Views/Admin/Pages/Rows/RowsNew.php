<?php

namespace App\Views\Admin\Pages\Rows;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class RowsNew
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();

        $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();

        $con->done();

        if (is_null($page)) return $response->withHeader("Location", "/admin/pages");

        if ($request->getMethod() == "GET") {

            return $view->render($response, 'admin/pages/rows/row.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath(),
                "page" => $page
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();

            $con = new Connection();

            $req = $con->alter(
                "INSERT INTO `row` (`page_id`, `order`) VALUES (?, ?)",
                "ii",
                $page["id"],
                $body["order"]
            );

            $con->done();

            return $response->withHeader("Location", "/admin/pages/{$page["id"]}/rows");
        }
    }
}
