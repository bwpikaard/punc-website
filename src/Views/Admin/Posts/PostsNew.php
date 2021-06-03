<?php

namespace App\Views\Admin\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class PostsNew
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        if ($request->getMethod() == "GET") {
            return $view->render($response, 'admin/posts/new.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath()
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();

            $con = new Connection();
            $date = date("Y-m-d H:i:s");
            
            $req = $con->alter("INSERT INTO `post` (`published`, `author`, `title`, `body`, `created`) VALUES (0, ?, ?, ?, '$date')", "iss", $_SESSION["user"]["id"], $body["title"], $body["content"]);

            $con->done();

            return $response->withHeader("Location", "/admin/posts/{$req->insert_id}");
        }
    }
}