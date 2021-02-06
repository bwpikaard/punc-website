<?php

namespace App\Views\Members;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Member
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $con = new Connection();
        
        $user = $con->select_where("SELECT * FROM user WHERE id=? AND ((permission_level > 0 AND hidden != 1) OR permission_level >= 3)", "i", $args["id"])->fetch_assoc();

        if (empty($user)) return $response->withHeader("Location", "/members");

        $con->done();

        return $view->render($response, 'members/member.twig', [
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
            "path" => $request->getUri()->getPath(),
            "nuser" => $user
        ]);
    }
}