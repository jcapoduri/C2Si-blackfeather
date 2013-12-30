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
<<<<<<< HEAD
error_reporting(E_ALL);

$app->post('/OAuth2/src/League/OAuth2/Server/Authorization.php', function(){
	
});
=======
>>>>>>> 8f7ecc3c83c01deb99071cb7c82a7ae9e661aab9

// Nd settings up
$config_data = file_get_contents('../config/blackfeather.json');
$config_json = json_decode($config_data, true);
$system = new \nd\nd($config_json);



// SLIM start point
$app->run();


?>
