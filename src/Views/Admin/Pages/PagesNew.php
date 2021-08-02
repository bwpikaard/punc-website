<?php

namespace App\Views\Admin\Pages;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class PagesNew
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        if ($request->getMethod() == "GET") {
            return $view->render($response, 'admin/pages/page.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath()
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();

            $con = new Connection();
            
            $req = $con->alter("INSERT INTO `page` (`slug`, `title`, `status`, `navigatable`, `author`, `heading`, `subheading`) VALUES (?, ?, ?, ?, ?, ?, ?)", "sssiiss",
            $body["slug"], $body["title"], $body["status"], $body["navigatable"], $_SESSION["user"]["id"], $body["heading"], $body["subheading"]);

            $con->done();

            return $response->withHeader("Location", "/admin/pages/{$req->insert_id}");
        }
    }
}