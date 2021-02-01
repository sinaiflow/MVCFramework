<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/dev.php';

use app\controllers\AuthController;
use app\core\Application;
use app\controllers\SiteController;

$app = new Application(dirname(__DIR__ . '/MVCFramework/')); //in my case /MVCFramework

$app->router->get('/',[SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact',[SiteController::class,'handleContact']);
$app->router->get('/login',[AuthController::class,'login']);
$app->router->post('/login',[AuthController::class,'login']);
$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);
$app->run();