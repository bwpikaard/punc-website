<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Conference
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();

        $config = $con->select("SELECT * FROM configuration");

        $config = array_reduce($config, function($result, $item) {
            $result[$item["key"]] = $item["value"];

            return $result;
        }, array());
        
        $con->done;

        return $view->render($response, 'conference.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "configuration" => $config
        ]);
    }
}