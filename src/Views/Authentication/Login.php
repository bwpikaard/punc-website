<?php

namespace App\Views\Authentication;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;

final class Login
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        if ($request->getMethod() == "GET") {
            return $view->render($response, 'auth/login.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath()
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();

            if (empty($body["username"]) || empty($body["password"]))
                return $view->render($response, 'auth/login.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "username" => $body["username"],
                    "error" => "Invalid username or password."
                ]);

            $con = new Connection();

            $user = $con->select_where("SELECT * FROM users WHERE username=?", "s", $body["username"])->fetch_assoc();

            $con->done;

            if (empty($user))
                return $view->render($response, 'auth/login.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "username" => $body["username"],
                    "error" => "Invalid username or password."
                ]);

            $password = $user["password"];

            if (!password_verify($body["password"], $password))
                return $view->render($response, 'auth/login.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "username" => $body["username"],
                    "error" => "Invalid username or password."
                ]);
            
            if ($user["approved"] < 1) 
                return $view->render($response, 'auth/login.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "username" => $body["username"],
                    "error" => "Your account has not been approved."
                ]);
            
            if ($user["status"] < 1) 
                return $view->render($response, 'auth/login.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "username" => $body["username"],
                    "error" => "Your account has not been activated."
                ]);
            
            $_SESSION["user"] = $user;
            unset($_SESSION["user"]["password"]);

            return $response->withHeader("Location", "/me");
        }
    }
}