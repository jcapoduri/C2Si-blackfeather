<?php
// CORS enable
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);

date_default_timezone_set('UTC');

require_once 'libs/Slim/Slim.php';
require_once 'libs/RedBean/rb.phar';
require_once 'libs/Auth/Auth.php';
require_once 'libs/Auth/AuthMiddleware.php';

// models
foreach (glob("models/*.php") as $filename)
{
    require_once $filename;
};

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'cookies.encrypt' => true,
    'cookies.secret_key' => 'my_secret_key',
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC
));

error_reporting(E_ALL);

//set Auth middleware
//$app->add(new AuthMiddleware());

//R::setup('mysql:host=localhost;dbname=blackfeather', 'root', 'Kotipelto.46');
R::setup('mysql:host=127.7.229.1;dbname=c9', 'jcapoduri', '');
//R::nuke();
// Noop - no operation (for testing)
$app->get('/noop', function () use ($app){
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->write('{}');
});

$app->get('/', function () use ($app){
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->write('{}');
});

foreach (glob("routes/*.php") as $filename)
{
    require_once $filename;
};
//R::freeze(TRUE);


// SLIM start point
$app->run();


?>
