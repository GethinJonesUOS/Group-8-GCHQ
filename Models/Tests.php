<?php

require_once 'Views/template/session_helper.php';
require_once 'Models/Database.php';
require_once 'Models/Test.php';

class Tests
{

    /**
     *Instantiating variables
     * @var PDO
     * @var database
     */
    protected $_dbHandle, $_dbInstance;


    /**
     * Costructor function class Tests
     *
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getDbConnection();
    }

    /**
     * Mutator method
     * Adding new new test results
     *
     * @param data
     *
     */
    public function addResults($data) {

        //gets current date
        $date = date('Y-m-d H:i:s');

        //Inserting values to the test table
        $sqlQuery = ("INSERT INTO tests (user_email, test_name, result, date) VALUES ( :user_email_ins, :test_name_ins, :result_ins, :date_ins)"); //Option2: add date using SQL VALUES (now())
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':user_email_ins', $_SESSION['email']);  //binding all needed parameters
        $statement->bindParam(':test_name_ins', $data['test_name']);
        $statement->bindParam(':result_ins', $data['result']);
        $statement->bindParam(':date_ins', $date);
        $statement->execute(); // execute the PDO statement
    }

    /**
     * Accessor method
     * Adding new new test results
     *
     * @return test_results
     *
     */
    public function getResults() {

        $sqlQuery = ("SELECT user_email, id, test_name, result, date FROM tests WHERE user_email LIKE :user_email_in");

        //Execute the query
        try
        {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->bindParam(':user_email_in', $_SESSION['email']);
            $statement->execute(); // execute the PDO statement
        }
        catch (PDOException $e)
        {
            //If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Test($row);
        }

        return $dataSet;
    }
}