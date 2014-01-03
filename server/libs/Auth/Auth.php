<?php

class Auth {
    private $handler;

    public function __construct(){}

    /**
    * @param: token: access token a validar
    * @return: boolean: so el token es valido o no, de ser valido, renovar la fecha de expiración
    */
    public function authentificate($token = $HTTP['auth-token']){

    }

    /**
    * @param: token: access token a validar
    * @return: id del usuario del token o -1
    */
    public function getUserId($token = $HTTP['auth-token']) {

    }

    /**
    * @param: userid: id del usuario
    * @return: string, token unico de acceso con 1hora de expiración
    */
    public function generateToken($userid) {

    }
};


?>