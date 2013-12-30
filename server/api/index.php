<?php
// CORS enable
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);


require '../libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
error_reporting(E_ALL);

$app->post('/OAuth2/src/League/OAuth2/Server/Authorization.php', function(){
	
});

$app->run();


?>
