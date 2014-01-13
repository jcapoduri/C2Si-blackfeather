<?php

namespace c2si;

class Auth {
    /**
    * esctructura del $handler:
    *
    */
    protected $handler;
    protected $token;

    public function __construct($token = null){
      $this->token = $token;
    }

// Authentication Area
    public function setHandler($handler){ $this->handler = $handler; }

    /**
    * @param: token: access token a validar
    * @return: boolean: so el token es valido o no, de ser valido, renovar la fecha de expiración
    */
    public function authentificate($token = null){
      $_token = $this->token;
      if (!is_null($token)) $_token = $token;
      if (is_null($_token)) return false;
        //var_dump("SELECT usr_id FROM auth_tokens WHERE expiration > CURRENT_TIMESTAMP AND token LIKE '".$token . "'");
      if ($this->handler->query("SELECT usr_id FROM auth_tokens WHERE expiration > CURRENT_TIMESTAMP AND token LIKE '" . $_token . "'")){
          $this->handler->query("UPDATE user SET expiration = NOW() + INTERVAL 1 HOUR");
          return true;
      }else{
          return false;
      };
    }

    /**
    * @param: token: access token a validar
    * @return: id del usuario del token o -1
    */
    public function getUserId($token = null) {
      $_token = $this->$token;
      if (!is_null($token)) $_token = $token;
      if ($this->handler->query("SELECT id_usr FROM auth_tokens WHERE expiration > CURRENT_TIMESTAMP AND token LIKE '". $token . "'")){
          $row = $result->fetch_array($result);
          return $row['usr_id'];
      }else{
          return 0;
      }
    }

    /**
    * @param: userid: id del usuario
    * @return: string, token unico de acceso con 1hora de expiración
    */
    public function generateToken($userid) {
      $token = "";
      if (!$userid) return $token;
      $insertedToekn = false;
      $tries = 5;
      do {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $insertedToken = $this->handler->query("INSERT INTO auth_tokens (token, expiration, usr_id) VALUES ('".$token."', NOW() + INTERVAL 1 HOUR, " . $userid . ")");
        $tries--;
      } while (!$insertedToken && !$tries);

      return $token;
    }

// Authorization area

    /**
    *   @param: scopes: string or string array
    *   @return: boolean, if is authorized or not
    */

    public function authorize($scopes) {
        if (!is_array($scopes)) $scopes = array($scopes);

        foreach($scopes as $scope) {

        };

        return true;
    }

};


?>