<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new WordSelector\App\DependencyInjection\WordServiceProvider());

$app->get('/', function () {
    return '';
});
$app->get('/random', "word.controller:random");

$app->run();
