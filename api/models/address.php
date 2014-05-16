<?php

require_once 'basemodel.php';

class Model_Address extends RESTorm {

    public function validate($json) {
        $ok = true;
        $err_validation = "";


        $ok = $ok && isset($json['address']);
        $ok = $ok && isset($json['address2']);
        $ok = $ok && isset($json['country']);
        $ok = $ok && isset($json['state']);
        $ok = $ok && isset($json['city']);
        $ok = $ok && isset($json['postalcode']);

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

    public function sanitize($data) {

    }

    public function update() {
    }
};

?>