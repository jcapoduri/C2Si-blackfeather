<?php

require_once 'basemodel.php';

class Model_Register extends RESTorm {

    public function validate($json) {
        $ok = true;
        $err_validation = "";


        $ok = $ok && isset($json->username);
        $ok = $ok && isset($json->password);
        $ok = $ok && isset($json->password2);
        $ok = $ok && isset($json->email);
        $ok = $ok && isset($json->email2);

        if (!$ok){            
            return "invalid JSON";
        };
        
        if ($json->password !== $json->password2)  $err_validation = "Passwords no coinciden";
        if ($json->email !== $json->email2)  $err_validation = "emails no coinciden";

        if (ereg("^[A-Za-z0-9_]{8,}$", $json->username)) {
            return "invalid username";
        };

        if (ereg("^[A-Za-z0-9_]{8,}$", $json->password)) {
            return "invalid password";
        };

        $email = filter_var($json->email, FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL);
        if (!$email) {
            return "invalid email";
        }
        
        return "";
    }

    public function fromJSON($data) {
        $status = validate($data);
        if ($status) {
            throw new ValidationException($status);
        };

        $data = $this->sanitize($data);

        $this->bean->username = $data->username;
        $this->bean->password = $data->password;
        $this->bean->email = $data->email;
        $this->bean->valid = false;
        $this->bean->token = "";
        $this->bean->expiration = date(DateTime::ISO8601, time() + (7 * 24 * 60 * 60));
    }

    public function generateToken() {
        $this->bean->token = md5($this->bean->username . $this->bean->expiration);
    }

    public function update() {
        $this->generateToken();
    }

};

?>