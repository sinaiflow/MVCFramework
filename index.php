<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/dev.php';
use app\core\Application;

$app = new Application(dirname(__DIR__ . '/MVCFramework/')); //in my case MVCFramework

$app->router->get('/','home');
$app->router->get('/contact','contact');
$app->run();