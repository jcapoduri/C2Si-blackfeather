<?php
// CORS enable
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);

// SLIM Framework, to provide REST capability and scalfolding
require '../../server/libs/Slim/Slim.php';
// small propietary ORM
require '../../server/libs/nd/nd.php';

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// Nd settings up
$config_data = file_get_contents('../../server/config/blackfeather.json');
$config_json = json_decode($config_data, true);
$system = new \nd\nd($config_json);

//get current config file
$app->get('/config', function() use ($app, $system) {
    //code here
});

//save config file
$app->put('/config', function() use ($app, $system) {
    //code here
});

// SLIM start point
$app->run();

?>