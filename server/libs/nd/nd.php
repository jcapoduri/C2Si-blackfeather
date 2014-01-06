<?php

namespace Nd;

class response {
        public $status = false;
        public $message = "";
        public $response = "";
        public $error_no = 0;

        public function toJson(){
                return json_encode($this);
        }
};

class neodynium {
        public function __construct($json_data){
                $this->raw = $json_data;
                $this->objects = array();
                $this->relations = array();
                $this->apps = array();
                $i = 0; $item = null; $keys = null;

                $len = count($json_data["objects"]);
                for($i = 0; $i < $len; $i++) {
                        $item = $json_data["objects"][$i];
                        $this->objects[$item["name"]] = $item;
                };

                $len = count($json_data["relations"]);
                for($i = 0; $i < $len; $i++) {
                        $item = $json_data["relations"][$i];
                        $this->relations[$item["name"]] = $item;
                };

                $len = count($json_data["storages"]);
                for($i = 0; $i < $len; $i++) {
                        $item = $json_data["storages"][$i];
                        $this->storages[$item["name"]] = $item;
                };

                $len = count($json_data["apps"]);
                $keys = array_keys($json_data["apps"]);
                for($i = 0; $i < $len; $i++) {
                        $item = $json_data["apps"][$keys[$i]];
                        $this->apps[$keys[$i]] = $item;
                };
        }

        public function startApp($appname){
                if (!isset($this->apps[$appname])) return false;
                $this->app = $this->apps[$appname];
                $storage = $this->storages[$this->app["storage"][0]];
                $this->handler = new \mysqli($storage["db_host"], $storage["db_user"], $storage["db_pass"], $storage["db_name"]);
                return ($this->handler == true);
        }

// ORM basic functions
        public function makeObject($obj, $row) {
                $fields_data = $this->getFieldsData($obj);
                $keys = array_keys($fields_data);
                $len = count($keys);
                $item = null;
                $return_obj = array();
                for ($i = 0; $i < $len; $i++) {
                        $item = $fields_data[$keys[$i]];
                        switch ($item["type"]) {
                                case 'array':
                                        $return_obj[$item["name"]] = $this->readRelation($item["relation_name"], $row["id"]);
                                        break;
                                case 'object':
                                        $return_obj[$item["name"]] = $this->readObject($item["object_name"], $row[$item["name"]]);
                                        break;
                                default:
                                        $return_obj[$item["name"]] = $row[$item["name"]];
                                        break;
                        }
                };

                return $return_obj;
        }

        public function readObject($obj_name, $id) {
                $obj = $this->objects[$obj_name];
                $fields_data = $this->getFieldsData($obj);
                $fields = $this->allFields($obj);
                $query = "SELECT `" . join("`, `", $fields) . "` FROM " . $this->app["map"][$obj_name];
                $query .= " WHERE id = " . $id . " AND deleted = 0";
                $result = $this->handler->query($query);
                if (!$result) return false;

                //make object from fields
                $data = $result->fetch_assoc();
                if (is_null($data)) return false;
                $return_obj = $this->makeObject($obj, $data);

                return $return_obj;
        }

        public function readObjectList($obj_name) {
                $obj = $this->objects[$obj_name];
                $fields_data = $this->getFieldsData($obj);
                $fields = $this->allFields($obj);
                $query = "SELECT `" . join("`, `", $fields) . "` FROM " . $this->app["map"][$obj_name];
                $query .= " WHERE deleted = 0";
                $result = $this->handler->query($query);
                if ($result === false) {
                        return false;
                } else {
                        $ret_array = array();
                        while($row = $result->fetch_assoc()){
                                $ret_array[] = $row;
                        };
                        return $ret_array;
                };
        }

        public function storeObject($obj_name, $json) {
                if (isset($json["id"])) {
                        return $this->updateObject($obj_name, $json["id"], $json);
                } else {
                        return $this->createObject($obj_name, $json);
                };
        }

        public function createObject($obj_name, $json) {
                $obj = $this->objects[$obj_name];
                $fields = $this->getFieldsData($obj, $json);
                $query = "INSERT INTO " . $this->app["map"][$obj_name] . " ";

                $i = 0;
                $keys = array_keys($json);
                $len = count($keys);
                $values = array();
        $lists = array();
                $tmp_value = null;
                $tmp_field = null;

                $relations = array();
                for ($i = 0; $i < $len; $i++) {
                        if ($keys[$i] == 'id') continue;
                        if (!isset($json[$keys[$i]])) continue;
                        $tmp_value = $json[$keys[$i]];
                        $tmp_field = $fields[$keys[$i]];
                        $item = $json[$keys[$i]];
                        switch ($tmp_field["type"]) {
                                case 'array':
                                        array_push($lists, $tmp_field);
                                        break;
                                case 'object':
                                        $values[$tmp_field["name"]] = $this->storeObject($item["object_name"], $item);
                                        break;
                                default:
                                        $values[$tmp_field["name"]] = $item;
                                        break;
                        }
                };

                $keys = array_keys($values);

                $query .= "(`" . join("`, `", $keys) . "`) VALUES ";
                $query .= "('" . join("', '", $values) . "')";
                $result = $this->handler->query($query);
                if ($result) {
                        $uid = $this->handler->insert_id;
            $len = count($lists);
                        for ($i = 0; $i < $len; $i++) {
                                $ok = $this->updateRelation($tmp_field["relation_name"], $uid, $item);
                                if (!$ok) return false;
                        };
                        return $uid;
                } else {
                        return false;
                };

        }

        public function updateObject($obj_name, $id, $json) {
                $obj = $this->objects[$obj_name];
                $fields = $this->getFieldsData($obj, $json);
                $query = "UPDATE " . $this->app["map"][$obj_name] . " SET ";

                $i = 0;
                $keys = array_keys($json);
                $len = count($keys);
                $values = array();
                $tmp_value = null;
                $tmp_field = null;

                $relations = array();
                for ($i = 0; $i < $len; $i++) {
                        if ($keys[$i] == 'id') continue;
                        if (!isset($json[$keys[$i]])) continue;
                        $tmp_value = $json[$keys[$i]];
                        $tmp_field = $fields[$keys[$i]];
                        $item = $json[$keys[$i]];
                        switch ($tmp_field["type"]) {
                                case 'array':
                                        $ok = $this->updateRelation($tmp_field["relation_name"], $id, $item);
                                        if (!$ok) return false;
                                        break;
                                case 'object':
                                        $values[$tmp_field["name"]] = $this->storeObject($item["object_name"], $item);
                                        break;
                                default:
                                        $values[$tmp_field["name"]] = $item;
                                        break;
                        }
                };

                $fields_update = array();
                $keys = array_keys($values);
                $len = count($values);
                for ($i = 0; $i < $len; $i++) {
                        array_push($fields_update, "`" . $keys[$i] . "` = '" . $values[$keys[$i]] . "'");
                };

                $query .= join(", ", $fields_update);
                $query .= " WHERE id = " . $id. ' AND deleted = 0';
        var_dump($query);
                return $this->handler->query($query);
        }

        public function updateRelation($rel_name, $id, $json) {
                $relation = $this->relations[$rel_name];
                $obj_to = $this->objects[$relation["object_to"]];

                $item = null;
                $i = 0;
                $len = count($json);

                $query = "UPDATE " . $this->app["map"][$relation["name"]] . " SET checked = 1  WHERE father = " . $id . " AND deleted = 0";
                var_dump($query);
                if (!$this->handler->query($query)) return false;

                for ($i = 0; $i < $len; $i++) {
                        $item = $json[$i];
                        if (is_numeric($item)) {
                                $query = "INSERT INTO " . $this->app["map"][$relation["name"]] . "(father, child) VALUES (" . $id . ", " . $item . ")";
                var_dump($query);
                                if (!$this->handler->query($query)) {
                                        $query = "UPDATE " . $this->app["map"][$relation["name"]] . " SET checked = 0  WHERE child = " . $item . " father = " . $id . " AND deleted = 0";
                                        var_dump($query);
                                        if (!$this->handler->query($query)) return false;
                                };
                        } else {
                                if (isset($item["id"])) {
                                        $this->updateObject($obj_to, $item["id"], $item);
                                        $query = "INSERT INTO " . $this->app["map"][$relation["name"]] . "(father, child) VALUES (" . $id . ", " . $item[$id] . ")";
                    var_dump($query);
                                        if (!$this->handler->query($query)) {
                                                $query = "UPDATE " . $this->app["map"][$relation["name"]] . " SET checked = 0  WHERE child = " . $item["id"] . " father = " . $id . " AND deleted = 0";
                                                var_dump($query);
                                                if (!$this->handler->query($query)) return false;
                                        };
                                } else {
                                        $oid = $this->createObject($obj_to, $item);
                                        $query = "INSERT INTO " . $this->app["map"][$relation["name"]] . "(father, child) VALUES (" . $id . ", " . $oid . ")";
                    var_dump($query);
                                        if (!$this->handler->query($query)) {
                                                $query = "UPDATE " . $this->app["map"][$relation["name"]] . " SET checked = 0  WHERE child = " . $oid . " father = " . $id . " AND deleted = 0";
                                                var_dump($query);
                                                if (!$this->handler->query($query)) return false;
                                        };
                                };
                        };
                };
                $query = "UPDATE " . $this->app["map"][$relation["name"]] . " SET deleted = 1  WHERE father = " . $id . " AND checked = 1";
                var_dump($query);
                if (!$this->handler->query($query)) return false;
                $query = "UPDATE " . $this->app["map"][$relation["name"]] . " SET checked = 0  WHERE father = " . $id ;
                var_dump($query);
                if (!$this->handler->query($query)) return false;
                return true;
        }

        public function readRelation($rel_name, $id) {
                $relation = $this->relations[$rel_name];
                $obj_to = $this->objects[$relation["object_to"]];

                $query = "SELECT child FROM " . $this->app["map"][$relation["name"]];
                $query .= " WHERE father = " . $id . " AND deleted = 0";

                $fields_data = $this->getFieldsData($obj_to);
                $fields = $this->allFields($obj_to);

                $query = "SELECT `" . join("`, `", $fields) . "` FROM " . $this->app["map"][$relation["object_to"]] . " WHERE id IN (" . $query . ")";
                $result = $this->handler->query($query);
                if ($result) {
                        $ret_array = array();
                        while($row = $result->fetch_assoc()){
                                array_push($ret_array, $this->makeObject($obj_to, $row));
                        };
                        return $ret_array;
                } else {
                        return false;
                };
        }

        public function deleteObject($obj_name, $id) {
            if (!isset($id)) return false;
            $query = "UPDATE " . $this->app["map"][$obj_name] . " SET deleted = 1 ";
            $query .= " WHERE id = " . $id;
            return $this->handler->query($query);
        }

        public function restoreObject($obj_name, $id) {
            if (!isset($id)) return false;
            $query = "UPDATE " . $this->app["map"][$obj_name] . " SET deleted = 0 ";
            $query .= " WHERE id = " . $id;
            return $this->handler->query($query);
        }

        public function riseObject($obj_name, $id) {
            $obj = $this->objects[$obj_name];
            $fields_data = $this->getFieldsData($obj);
            $fields = $this->allFields($obj);
            $query = "SELECT `" . join("`, `", $fields) . "` FROM " . $this->app["map"][$obj_name];
            $query .= " WHERE id = " . $id;
            $result = $this->handler->query($query);
            if (!$result) return false;

            //make object from fields
            $data = $result->fetch_assoc();
            if (is_null($data)) return false;
            $return_obj = $this->makeObject($obj, $data);

            return $return_obj;
        }
// helper functions
        public function parentRelation($rel_name, $child_id) {
        $relation = $this->relations[$rel_name];
                $obj_to = $this->objects[$relation["object_from"]];
        $fields = $this->allFields($obj_to);

            $query = "SELECT " . $this->app["map"][$relation["object_from"]] . "`" . join("`, " . $this->app["map"][$relation["object_from"]] . "`", $fields) . "` FROM " . $this->app["map"][$relation["object_from"]];
        $query .= " INNER JOIN " . $this->app["map"][$relation["name"]] . " ON " . $this->app["map"][$relation["name"]] .".id";
        $query .= " = " . $this->app["map"][$relation["object_from"]] . ".id";
                $query .= " WHERE child = " . $id . " AND deleted = 0";

                $result = $this->handler->query($query);
                if ($result) {
                        $ret_array = array();
                        while($row = $result->fetch_assoc()){
                                array_push($ret_array, $this->makeObject($obj_to, $row));
                        };
                        return $ret_array;
                } else {
                        return false;
                };
    }

        //string array with the fields of the object
        private function allFields($obj, $all = false){
                $fields = $this->getFieldsData($obj);
                $keys = array_keys($fields);
                $return_arr = array();
                $len = count($fields);
                $item = null;
                for ($i = 0; $i < $len; $i++) {
                        $item = $fields[$keys[$i]];
                        if ($item["type"] != "array") array_push($return_arr, $item["name"]);
                };

                return $return_arr;
        }

        private function getField($fieldname) {
                $fields = $obj["fields"];
                $return_field = null;
                $len = count($fields);
                for ($i = 0; $i < $len; $i++) {
                        if ($fields[$i]["name"] == $fieldname) $return_field = $fields[$i];
                };
                return $return_field;
        }

        //array in proper way of the json fields present
        private function jsonToFields($obj, $json) {
                $fields = $this->allFields($obj);
                $return_fields = array();
                $keys = array_keys($json);
                $len = count($keys);
                for ($i = 0; $i < $len; $i++) {
                        if (array_key_exists($keys[$i], $fields))
                                //$return_fields[] = '`' . $keys[$i] . '` = \'' .  $json[$keys[$i]] . '\'';
                                $return_fields[$keys[$i]] =  $json[$keys[$i]] ;
                };
                return $return_fields;
        }

        private function getFieldsData($obj) {
                $fields = $obj["fields"];
                $return_fields = array();
                $len = count($fields);
                for ($i = 0; $i < $len; $i++) {
                        $return_fields[$fields[$i]["name"]] = $fields[$i];
                };
                if ($obj["nd_fields"]) $return_fields = array_merge(neodynium::$nd_fields, $return_fields);
                return $return_fields;
        }

        public function query() {
            return new query($this);
        }
// database functions TO DO
        //
        public function buildPersistency() {
            $this->handler->autocommit(false);
            // podria usar keys
            foreach ($this->objects as $obj_name => $obj) {
                $this->buildObjectPersistency($obj_name);
            };
            $this->handler->commit();
            var_dump($this->handler->error);
        }

        private function buildObjectPersistency($obj_name) {
            $obj = $this->objects[$obj_name];
            $fields_data = $this->getFieldsData($obj);
            $keys = array_keys($fields_data);
            $len = count($keys);
            $item = null;

            $tablename =  $this->app["map"][$obj_name];

            //create table
            $this->handler->query('CREATE TABLE IF NOT EXISTS ' . $tablename . '(`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `mtime` timestamp NOT NULL on update CURRENT_TIMESTAMP,
                  `dtime` timestamp NOT NULL,
                  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
                  PRIMARY KEY (`id`))'
            );
            var_dump('CREATE TABLE IF NOT EXISTS ' . $tablename . ' error:' .$this->handler->error);

            for ($i = 0; $i < $len; $i++) {
                    $item = $fields_data[$keys[$i]];
                    //$this->handler->query('ALTER TABLE ' . $tablename . '');
                    //var_dump($this->handler->error);
                    switch ($item["type"]) {
                            case 'array':
                                    //$return_obj[$item["name"]] = $this->readRelation($item["relation_name"], $row["id"]);
                                    break;
                            case 'object':
                                    //$return_obj[$item["name"]] = $this->readObject($item["object_name"], $row[$item["name"]]);
                                    break;
                            default:
                                    //$return_obj[$item["name"]] = $row[$item["name"]];
                                    break;
                    }
            };
        }

        private function buildRelationPersistency($relName) {

        }

        public function beginTransaction() {}

        public function endTransaction() {}

        private $objects;
        private $relations;
        private $storages;
        private $apps;
        private $app;
        private $raw;
        public  $handler;

        public static $nd_fields = array(
                        array(
                                "name" => "id",
                                "isKey" => true,
                                "unique" => true,
                                "autoincremental" => true,
                                "type" => "number"
                        ),
                        array(
                                "name" => "ctime",
                                "type" => "timestamp"
                        ),
                        array(
                                "name" => "mtime",
                                "type" => "timestamp"
                        ),
                        array(
                                "name" => "dtime",
                                "type" => "timestamp"
                        ),
                        array(
                                "name" => "deleted",
                                "type" => "bool"
                        ),
                );
};

class query {
    protected $nd;
    protected $entity;
    protected $isRelation = false;
    protected $predicative = null;

    public function __construct(neodynium $nd) {
        $this->nd = $nd;
        return $this;
    }

    /*
    * select and entity to work
    */
    public function entity($entity_name) {
        $this->entity = $entity_name;
        return $this;
    }

    /*
    *
    */
    public function relation($relation_name) {
        $this->isRelation = true;
        $this->entity = $relation_name;
        return $this;
    }

    /*
    * @return predicative
    */
    public function filter($column, $filtertype, $value) {
        $this->predicative = new predicative($column, $filtertype, $this->nd->handler->real_escape_string($value));
        return $this->predicative;
    }

    /*
    * execute current query
    **/
    public function exec() {
        // optimizar trayendote los campos solamente
        $query = "SELECT * FROM " . $this->entity;
        if (!is_null($this->predicative)) $query .= $this->predicative->generateSQL();
        return $this->nd->handler->query($query);
    }
};

class predicative {
    protected $column = "";
    protected $filterType = "";
    protected $filterValue = "";
    protected $negate = null;
    protected $and_others = array();
    protected $or_others = array();

    public function __construct($column, $filterType, $filterValue) {
        $this->column = $column;
        $this->filterType = $filterType;
        $this->filterValue = $filterValue;
    }

    public function generateSQL() {
        $query = $this->filterToSql();
        $and_array = array();
        $and_query = "";
        $or_array = array();
        $or_query = "";

        foreach ($this->and_others as $pred) {
            array_push($and_array, $pred->generateSQL());
        };
        $and_query = join($and_array, " AND ");

        foreach ($this->or_others as $pred) {
            array_push($or_array, $pred->generateSQL());
        };
        $or_query = join($or_array, " OR ");

        $query = "(" . $query . ")";
        if ($and_query) $query .= " AND (" . $and_query . ")";
        if ($or_query) $query .= " AND (" . $or_query . ")";
        if (!is_null($this->negate)) $query .= " AND NOT (" . $this->negate->generateSQL() . ")";
    }

    protected function filterToSql() {
        $query = $this->column;
        switch ($this->filterType) {
            case "startWith":
                $query .= " LIKE '" . $this->filterValue . "%'";
                return $query; //<-------- special case, REFACTOR!
                break;
            case "endsWith":
                $query .= " LIKE '%" . $this->filterValue;
                break;
            case "like":
            case "equal":
            case "=":
                $query .= is_numeric($this->filterValue) ? " = " : " LIKE '";
                break;
            default:
                $query .= $this->filterType;
                break;
        };
        if (is_numeric($this->filterValue)) $query .= "'";
    }

    public function logical_and(predicative $other) {
        array_push($this->and_others, $other);
    }

    public function logical_or(predicative $other) {
        array_push($this->and_others, $other);
    }

    public function logical_not(predicative $other) {
        $this->negate = $other;
    }
};

class error extends \Exception {

}
?>