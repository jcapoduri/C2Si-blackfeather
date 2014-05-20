<?php

require_once 'basemodel.php';

class Model_Application extends RESTorm {

    public function validate($json){
        $ok = true;
        $ok = $ok && isset($json->name);
        $ok = $ok && isset($json->description);

        return $ok;
    }

    public function fromJSON($json){}

    public function sanitize($data){}

};

?>