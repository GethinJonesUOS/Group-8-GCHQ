<?php

class Test
{
    /**
     *Instantiating variables
     * @var id,
     * @var user_email
     * @var testname
     * @var result
     * @var date
     */
    protected  $_id, $_user_email, $_test_name, $_result, $_date;

    /**
     * Costructor function for type "Test"
     *
     * @param database array
     *
     */
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_user_email = $dbRow['user_email'];
        $this->_test_name = $dbRow['test_name'];
        $this->_result = $dbRow['result'];
        $this->_date = $dbRow['date'];
    }

    /**
     * Accessors Method
     * @return test-id
     */
    public function getTestID() {
        return $this->_id;
    }

    /**
     * @return user_email
     */
    public function getUserEmail() {
        return $this->_user_email;
    }

    /**
     * @return test_name
     */
    public function getTestName() {
        return $this->_test_name;
    }

    /**
     * @return test_result
     */
    public function getResult() {
        return $this->_result;
    }

    /**
     * @return test_email
     */
    public function getDate() {
        return $this->_date;
    }
}