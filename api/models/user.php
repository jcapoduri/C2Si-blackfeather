<?php

require_once 'basemodel.php';

class Model_User extends RESTorm {

    public function validate($json) {
        $ok = true;
        $err_validation = "";

        //email, password, username
        $ok = $ok && isset($json['name']);
        $ok = $ok && isset($json['lastname']);
        $ok = $ok && isset($json['active']);
        $ok = $ok && isset($json['username']);
        $ok = $ok && isset($json['password']);
        $ok = $ok && isset($json['email']);
        $ok = $ok && isset($json['gender']);

        if (!$ok){            
            return "invalid JSON";
        };
        
        if ($json['password'] !== $json['password2'])  $err_validation = "Passwords no coinciden";
        if ($json['email'] !== $json['email2'])  $err_validation = "emails no coinciden";

        if (ereg("^[A-Za-z0-9_]{8,}$", $json['username'])) {
            return "invalid username";
        };

        if (ereg("^[A-Za-z0-9_]{8,}$", $json['password'])) {
            return "invalid password";
        };

        $email = filter_var($json['email'], FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL);
        if (!$email) {
            return "invalid email";
        }
        
        return "";
    }

    public function fromJSON($data) {
    }

    public function update() {
    }
};

?>