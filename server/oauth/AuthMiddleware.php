<?php

namespace c2si;

require_once '../libs/Auth/Auth.php';

class AuthMiddleware extends \Slim\Middleware
{
    protected $system;
    protected $auth;
    
    public function __construct($nd)
    {
      $this->system = $nd;
      $this->auth = new \c2si\Auth();
      $this->auth->handler = $this->system->handler;
    }

    /**
     * Call
     *
     * This method will check the HTTP request headers for previous authentication. If
     * the request has already authenticated, the next middleware is called. Otherwise,
     * a 401 Authentication Required response is returned to the client.
     */
    public function call()
    { 
      $request = $this->app->request;
      
      //si intenta acceder al login, no valido para que pueda pedir token
      if ($request->getRootUri() !== '/login') {
        $ok = $this->auth->authorize($request->headers->get('ACCESS_TOKEN'));
        if (!$ok) {
          $res->status(401);
        }
      };
      $this->next->call();
    }
}
?>