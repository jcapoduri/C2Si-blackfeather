<?php

$app->group('/raw', function () use ($app) {
    $response = $app->response();
    $response['Content-Type'] = 'application/json';

    $app->get('/:object', function ($object) use ($app) {
        $bean = R::findAll($object);
        $app->response()->write(json_encode(R::exportAll($bean)));
    });

    $app->get('/:object/:id', function ($object, $id) use ($app) {
        $bean = R::load($object, $id);
        $app->response()->write(json_encode($bean->export())); 
    });

    $app->post('/:object', function ($object) use ($app) {
        $bean = R::dispense($object);
        $bean->import(json_decode($app->request()->getBody()));
        $app->response()->write(R::store($bean));
    });

    $app->put('/:object/:id', function ($object, $id) use ($app) {
        $bean = R::load($object, $id);
        $bean->import(json_decode($app->request()->getBody()));
        $bean->sharedApplication[] = R::load("application", 1);
        $bean->sharedApplication[] = R::load("application", 2);
        var_dump($bean->export());
        $app->response()->write(R::store($bean));
    });

});

?>