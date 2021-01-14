<?php

require_once 'Views/template/session_helper.php';
require_once 'Models/Database.php';
require_once 'Models/Test.php';

class Tests
{

    protected $_dbHandle, $_dbInstance;


    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getDbConnection();
    }

    public function addResluts($data) {

        //gets current date
        $date = date('Y-m-d H:i:s');

        //Inserting values to the test table
        $sqlQuery = ("INSERT INTO tests (user_email, result, date) VALUES ( :user_email_ins, :result_ins, :date_ins)"); //Option2: add date using SQL VALUES (now())
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':user_email_ins', $_SESSION['email']);  //binding all needed parameters
        $statement->bindParam(':result_ins', $data['email']);
        $statement->bindParam(':date_ins', $date);
        $statement->execute(); // execute the PDO statement
    }

    public function getResults() {

        $sqlQuery = ("SELECT * FROM tests WHERE user_email = :user_email_in");

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

        $row = $statement->fetch();
        $test[] = new Test($row);

        return $test;
    }
}