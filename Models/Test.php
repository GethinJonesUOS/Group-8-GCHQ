<?php

class Test
{
    //Instantiating variables
    protected  $_id, $_result, $_date;

    //Constructor
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_result = $dbRow['result'];
        $this->_date = $dbRow['date'];
    }

    //Get methods to access
    public function getTestID() {
        return $this->_id;
    }

    public function getResult() {
        return $this->_result;
    }

    public function getDate() {
        return $this->_date;
    }
}