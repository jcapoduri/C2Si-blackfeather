<?php

//DEBUG
ini_set('display_errors', 1);

// SLIM Framework, to provide REST capability and scalfolding
require 'libs/Slim/Slim.php';

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'templates.path' => 'bases'
));

$app->get('/', function() use ($app) {
    $app->render('index.html');
});

$app->get('/:username', function($username) use ($app) {
    $app->render('index.html');
});

// SLIM start point
$app->run();

?>