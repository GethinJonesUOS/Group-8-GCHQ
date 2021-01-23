<?php

require_once 'Models/Database.php';
require_once 'Models/File.php';

class Files {
    protected $_dbHandle;
    protected $_dbInstance;

    /**
     * Files constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getDbConnection();
    }

    /**
     * Get an array of EMail objects from the database.
     *
     * @return array
     */
    public function getFilesList() : array {
        $sqlQuery = 'SELECT * FROM files';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new File($row);
        }
        return $dataSet;
    }

    /**
     * Get a single file from the database.
     *
     * @param $fileName string The filename of the File record to retrieve
     * @return File A file object.
     */
    public function getFileFromName($fileName) : File {
        $sqlQuery = 'SELECT * FROM files where filename = :filename';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(':filename', $fileName);
        $statement->execute();

        return new File($statement->fetch());
    }
}