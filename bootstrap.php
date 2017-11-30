<?php

session_start();
require __DIR__ . '/vendor/autoload.php';
$app = new Snippet\Application();
$app->get('/', 'PageController@index');
$app->get('/login', 'AccountController@login');
$app->run();