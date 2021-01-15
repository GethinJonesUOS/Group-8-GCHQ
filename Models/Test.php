<?php

class Test
{
    //Instantiating variables
    protected  $_id, $_user_email, $_test_name, $_result, $_date;

    //Constructor
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_user_email = $dbRow['user_email'];
        $this->_test_name = $dbRow['test_name'];
        $this->_result = $dbRow['result'];
        $this->_date = $dbRow['date'];
    }

    //Get methods to access
    public function getTestID() {
        return $this->_id;
    }

    public function getUserEmail() {
        return $this->_user_email;
    }

    public function getTestName() {
        return $this->_test_name;
    }

    public function getResult() {
        return $this->_result;
    }

    public function getDate() {
        return $this->_date;
    }
}