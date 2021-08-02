<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use App\Lib\APIRequest;
use App\Lib\ErrorHandler;
use \App\Database\Connection;

final class GlobalVariables
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $view = Twig::fromRequest($request);

        $view->getEnvironment()->addGlobal("path", $request->getUri()->getPath());
        
        $con = new Connection();

        $pages = $con->select("SELECT * FROM page WHERE `navigatable`=1");

        $view->getEnvironment()->addGlobal("pages", $pages);
    
        return $handler->handle($request);
    }
}