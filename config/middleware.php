<?php

use Selective\Config\Configuration;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Errors\HtmlErrorRenderer;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    $app->add(ErrorMiddleware::class);
    
    $app->add(new \App\Middleware\GlobalVariables());
    
    $twig = Twig::create(__DIR__ . '/../templates');
    $app->add(TwigMiddleware::create($app, $twig));
};