<?php

namespace Nd;

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
    * to be implemented
    */
    public function relation($relation_name) {
        $this->isRelation = true;
        $this->entity = $relation_name;
        return $this;
    }

    /*
    *
    */
    public function filterBy($column, $filtertype, $value) {
        $this->predicative = new predicative($column, $filtertype, $this->nd->handler->real_escape_string($value));
        return $this;
    }

    /*
    *
    */
    public function andBy($column, $filtertype, $value) {
        if (is_null($this->predicative)) throw new error("and predicative withour predicate");
        $pred = new predicative($column, $filtertype, $this->nd->handler->real_escape_string($value));
        $this->predicative->logical_and($pred);
        return $this;
    }

    /*
    *
    */
    public function orBy($column, $filtertype, $value) {
        if (is_null($this->predicative)) throw new error("or predicative withour predicate");
        $pred = new predicative($column, $filtertype, $this->nd->handler->real_escape_string($value));
        $this->predicative->logical_or($pred);
        return $this;
    }

    /*
    *
    */
    public function notBy($column, $filtertype, $value) {
        if (is_null($this->predicative)) throw new error("not predicative withour predicate");
        $pred = new predicative($column, $filtertype, $this->nd->handler->real_escape_string($value));
        $this->predicative->logical_not($pred);
        return $this;
    }


    /*
    *
    */
    public function filter() {
        return $this->predicative;
    }

    /*
    * execute current query
    **/
    public function exec() {
        $fields = $this->nd->getObjectFieldList($this->entity);
        $query = "SELECT `" . join($fields, '`, `') . "` FROM " . $this->nd->entityMap($this->entity);
        if (!is_null($this->predicative)) $query .= " WHERE " . $this->predicative->generateSQL();
        return $this->nd->handler->query($query);
    }
};

?>