<?php

class ValidationException extends Exception{
// Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
};

abstract class RESTorm extends RedBean_SimpleModel {

    public function toJSON () {
        return json_encode($this->bean->export());
    }

    abstract public function fromJSON ($data);

    abstract public function validate($data);

    public function sanitize($data) {
        /*foreach ($data as $key => $value) {
            if (is_array($value) && is_object($value)) {
                $data[$key] = $this->sanitize($value);
            } else {
                $data[$key] = filter_var($value, FILTER_SANITIZE_MAGIC_QUOTES);
            };
        };*/
        return $data;
    }

}

?>