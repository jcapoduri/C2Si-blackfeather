<?php
// CORS enable
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);

date_default_timezone_set('UTC');

// SLIM Framework, to provide REST capability and scalfolding
require '../libs/Slim/Slim.php';
// small propietary ORM
require '../libs/nd/nd.php';
// small propietary Auth
require '../libs/Auth/Auth.php';

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

error_reporting(E_ALL);

// Nd settings up
$config_data = file_get_contents('../config/blackfeather.json');
$config_json = json_decode($config_data, true);
$system = new \nd\neodynium($config_json);
$system->startApp("web");

// Noop - no operation (for testing)

$app->get('/noop', function () use ($app){
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->write('{}');
});

require_once 'security/access.php';

// SLIM start point
$app->run();


?>
