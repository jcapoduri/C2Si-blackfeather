<?php

//DEBUG
ini_set('display_errors', 1);

// SLIM Framework, to provide REST capability and scalfolding
require 'libs/Slim/Slim.php';
// small propietary ORM
require 'libs/nd/nd.php';
// small propietary Auth
require 'libs/Auth/Auth.php';

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'templates.path' => 'bases'
));

error_reporting(E_ALL);

// Nd settings up
$config_data = file_get_contents('config/blackfeather.json');
$config_json = json_decode($config_data, true);
$system = new \nd\neodynium($config_json);
$system->startApp("web");

$app->get('/', function() use ($app) {
    $app->render('login.html');
});

$app->get('/:username', function($username) use ($app, $system) {
    $auth = new \c2si\Auth();
    $auth->setHandler($system->handler);
    $token = $app->request->headers->get('ACCESS_TOKEN');
    if (!$token) $token = $app->getCookie('ACCESS_TOKEN');
    if ($auth->authentificate($token)) {
        $app->render('raven.html');
    } else {
        $app->redirect('/');
    };
});

// SLIM start point
$app->run();

?>