<?php
// CORS enable
// Add OAuth middleware

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
ini_set('display_errors', 1);


require '../libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

//use \Slim\Slim;
use \server\libs\Slim\Slim;
use \server\oauth\CsrfGuard;
use \server\oauth\HttpBasicAuth;

$app = new \Slim\Slim();
$app->add(new CsrfGuard());

$app = new \Slim\Slim();
$app->add(new HttpBasicAuth($_POST["username"],$_POST["password"]));


$app = new \Slim\Slim();
error_reporting(E_ALL);

$app->post('/signin', function(){
	
});

$app->run();

$tabla = "

<table>
    <form action='index.php'>
        <tr>
            <td>Usuario</td>
            <td>Contrasenia</td>
        </tr>
        <tr>
            <td><input type='text' name='username' id='username'></td>
            <td><input type='password' name='password' id='password'></td>
            <td> <input type='submit'  value='Submit' ></td>
            <input type='hidden' name='<?php echo $csrf_key; ?>' value='<?php echo $csrf_token; ?>'>
        </tr>
    </form> 
</table>


";

echo $tabla;
?>
