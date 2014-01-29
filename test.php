<?php
    ini_set('display_errors', 1);

    // small propietary ORM
    require 'api/libs/nd/nd.php';

    //var_dump(getenv('IP'));

    // Nd settings up
    $config_data = file_get_contents('api/config/blackfeather.json');
    $config_json = json_decode($config_data, true);
    $system = new \nd\neodynium($config_json);
    $system->startApp("web");

    /*$query = new \nd\query($system);
    $query->relation("application_to_resource", "resource");
    $res = $query->exec();
    var_dump($res);
    echo $system->handler->error;
    echo $system->handler->errno;
    while ($rep = $res->fetch_assoc()) var_dump($rep);*/

    $test = new \nd\persistence($system);
    $test->generatePersistence();

?>