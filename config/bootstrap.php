<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = parse_ini_file(dirname(__DIR__) . "/config.ini");

define("DB_HOST", $config["db_host"]);
define("DB_USERNAME", $config["db_username"]);
define("DB_PASSWORD", $config["db_password"]);
define("DB_DATABASE", $config["db_database"]);
define("MAIL_USERNAME", $config["mail_username"]);
define("MAIL_PASSWORD", $config["mail_password"]);
define("RECAPTCHA_KEY", $config["recaptcha_key"]);

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/container.php');

$container = $containerBuilder->build();

$app = $container->get(App::class);

session_start();

(require __DIR__ . '/routes.php')($app);
(require __DIR__ . '/middleware.php')($app);

return $app;