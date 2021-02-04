<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/dev.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__ . '/MVCFramework/'));
$dotenv->load();

use app\controllers\AuthController;
use app\core\Application;
use app\controllers\SiteController;

$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new Application(dirname(__DIR__ . '/MVCFramework/'),$config); //in my case /MVCFramework

$app->router->get('/',[SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact',[SiteController::class,'handleContact']);
$app->router->get('/login',[AuthController::class,'login']);
$app->router->post('/login',[AuthController::class,'login']);
$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);
$app->router->get('/profile',[AuthController::class,'profile']);
$app->router->get('/logout',[AuthController::class,'logout']);


$app->run();