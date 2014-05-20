<?php

require_once 'basemodel.php';

class Model_Business extends RESTorm {

    public function validate($json) {
        $ok = true;
        $err_validation = "";

        $ok = $ok && isset($json->name);
        $ok = $ok && isset($json->address);
        $ok = $ok && isset($json->cuit);
        $ok = $ok && isset($json->manager);

        if (!$ok){            
            return "invalid JSON";
        };        
        
        return "";
    }

    public function fromJSON($data) {
    }

};

?>