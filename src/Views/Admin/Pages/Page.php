<?php

namespace App\Views\Admin\Pages;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Page
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        if ($request->getMethod() == "GET") {
            $view = Twig::fromRequest($request);

            $con = new Connection();

            $page = $con->select_where("SELECT * FROM page WHERE id=?", "i", $args["id"])->fetch_assoc();

            $con->done();

            return $view->render($response, 'admin/pages/page.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath(),
                "page" => $page
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();
            $con = new Connection();

            $con->alter("UPDATE `page` SET `slug`=?, `title`=?, `status`=?, `navigatable`=?, `heading`=?, `subheading`=? WHERE id=?", "sssissi", $body["slug"], $body["title"], $body["status"], $body["navigatable"], $body["heading"], $body["subheading"], $args["id"]);

            $con->done();

            return $response->withHeader("Location", "/admin/pages/{$args["id"]}");
        }
    }
}
