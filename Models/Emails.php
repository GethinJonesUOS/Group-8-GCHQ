<?php

require_once 'Models/Database.php';
require_once 'Models/Email.php';

class Emails {
    protected $_dbHandle;
    protected $_dbInstance;

    /**
     * Emails constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getDbConnection();
    }

    /**
     * Get an array of EMail objects from the database.
     *
     * @return array An array of Email objects
     */
    public function getEmails() : array {
        $sqlQuery = 'SELECT * FROM emails';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Email($row);
        }
        return $dataSet;
    }

    /**
     * Get an email object from the database, specified by its ID.
     *
     * @param $id table ID of the email record.
     * @return Email Email object from the database.
     */
    public function getEmail($id) : Email {
        $sqlQuery = 'SELECT * FROM emails WHERE id = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(':id', $id);
        $statement->execute();

        if ($statement->rowCount() != 0) {
            $email = new Email($statement->fetch());
        } else {
            $email = null;
        }

        return $email;
    }
}