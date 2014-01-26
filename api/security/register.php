<?php

$app->post('/register', function () use ($system, $app) {
    $auth = new \c2si\Auth();
    $auth->setHandler($system->handler);

    $json = json_decode($app->request()->getBody(), true);

    $query = $system->query("email");
    $query->filterBy("username", "equal", $json["username"])->andBy("password", "equal", md5($json["password"]));

    $resp = $query->exec();

    if ($resp && $user = $resp->fetch_assoc()) {
        $token = $auth->generateToken($user["id"]);
        $app->response->headers->set('ACCESS_TOKEN', $token);
        $app->setCookie('ACCESS_TOKEN', $token);
        $app->response()->status(200);
        $app->response()->write($token);
    } else {
        $app->response()->status(500);
        $app->response()->write(\nd\response::fail("invalid user")->toJson());
    };
});

?>