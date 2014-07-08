<?php

$app->group('/register', function() use ($app) {
    $response = $app->response();
    $response['Content-Type'] = 'application/json';

    $app->post('/user', function() use ($app) {
        $response = $app->response();
        $response['Content-Type'] = 'application/json';

        $json = json_decode($app->request()->getBody());

        $bean = R::dispense("register");
        try {
            $bean->fromJSON($json);
            R::store($bean);
            $app->response()->write($bean->token);
        } catch(Exception $e) {
            $app->response()->status(500);
            $app->response()->write(response::fail($e->getMessage())->toJson());
        };

    });

    $app->get('/user/:token', function($token) use ($app) {
        $token = R::findOne('user', 'token LIKE ?', array($token));
        if ($token) {
            $app->response()->write($token->id);
        } else {
            $app->response()->status(500);
            $app->response()->write(response::fail("invalid token")->toJson());
        };
    });

    // Generate User
    $app->post('/user/:token', function($token) use ($app) {

    });
});

?>