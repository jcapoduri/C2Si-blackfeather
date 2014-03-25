<?php
// CORS enable
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);

date_default_timezone_set('UTC');

// SLIM Framework, to provide REST capability and scalfolding
require_once 'libs/Slim/Slim.php';
// small propietary ORM
require_once 'libs/RedBean/rb.phar';
// small propietary Auth
require_once 'libs/Auth/Auth.php';
require_once 'libs/Auth/AuthMiddleware.php';


class response {
	public $status = false;
    public $message = "";
    public $response = "";
    public $error_no = 0;

    public function toJson(){
            return json_encode($this);
    }

    protected static function generateResponse($message, $response = "", $errno = 0) {
        $res = new response();
        $res->status = true;
        $res->message = $message;
        $res->response = $response;
        $res->error_no = $errno;
        return $res;
    }

    public static function pass($message, $response = "", $errno = 0) {
        $res = response::generateResponse($message, $response, $errno);
        $res->status = true;
        return $res;
    }

    public static function fail($message, $response = "", $errno = 0) {
        $res = response::generateResponse($message, $response, $errno);
        $res->status = false;
        return $res;
    }
}

// SLIM setting up
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

error_reporting(E_ALL);

//set Auth middleware
//$app->add(new AuthMiddleware());

//R::setup('mysql:host=localhost;dbname=test', 'root', '');
R::setup('mysql:host=127.11.188.129;dbname=c9', 'jcapoduri', '');
//R::nuke();
// Noop - no operation (for testing)
$app->get('/noop', function () use ($app){
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->write('{}');
});

require_once 'security/access.php';
require_once 'security/register.php';

//R::freeze(TRUE);

$app->get('/user', function () use ($app) {
	$response = $app->response();
    $response['Content-Type'] = 'application/json';
    //$users = R::find('newbusiness');
    //$users = R::getAll( 'SELECT * FROM user' );
    //$response->write(json_encode(R::exportAll($users)));
    //$response->write(json_encode($users));
    //$response->write("{}");
    //var_dump(R::exec("SELECT * FROM user"));
});

// SLIM start point
$app->run();


?>
