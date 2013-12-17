<?php
// CORS enable
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);

// SLIM Framework, to provide REST capability and scalfolding
require '../libs/Slim/Slim.php';
// small propietary ORM
require '../libs/nd/nd.php';

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// Nd settings up
$config_data = file_get_contents('../config/blackfeather.json');
$config_json = json_decode($config_data, true);
$system = new \nd\nd($config_json);



// SLIM start point
$app->run();

?>