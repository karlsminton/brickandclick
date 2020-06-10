<?php

use Brick\App\Application;
use Brick\App\Route\SimpleRoute;

require 'vendor/autoload.php';

$app = Application::create();

$route = new SimpleRoute([
    '/' => Click\Framework\Controller\IndexController::class,
]);

$app->addRoute($route);
$app->run();