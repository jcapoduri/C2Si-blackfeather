<?php
    ini_set('display_errors', 1);

    // small propietary ORM
    require 'server/libs/nd/nd.php';

    //var_dump(getenv('IP'));

    // Nd settings up
    $config_data = file_get_contents('server/config/blackfeather.json');
    $config_json = json_decode($config_data, true);
    $system = new \nd\neodynium($config_json);
    $system->startApp("web");

    //var_dump($system);

    $query = $system->query("user")->filterBy("username", "startWith", "J")->orBy("username", "startWith", "s");
    $res  =$query->exec();
    var_dump($res);
    echo $system->handler->error;
    echo $system->handler->errno;
    while ($rep = $res->fetch_assoc()) var_dump($rep);

?>