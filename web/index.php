<?php

require_once __DIR__ . '/../vendor/autoload.php';

define("ROOT_PATH", __DIR__ . "/..");

$app = new Silex\Application();

switch ($_SERVER['SERVER_NAME']) {
    case "localhost":
        require __DIR__ . '/../resources/config/dev.php';
        break;
    default:
        require __DIR__ . '/../resources/config/prod.php';
        break;
}

require __DIR__ . '/../src/app.php';

$app['http_cache']->run();
