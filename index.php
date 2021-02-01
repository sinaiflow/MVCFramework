<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/dev.php';
use app\core\Application;

$app = new Application();

$app->router->get('/',function (){
    return "Hello index!";
});
$app->router->get('/contact',function (){
    return "Hello contact!";
});
$app->run();