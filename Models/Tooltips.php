<?php

require_once 'Models/Database.php';
require_once 'Models/Tooltip.php';

class Tooltips {

    protected $_dbHandle;
    protected $_dbInstance;

    /**
     * Tooltips constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getDbConnection();
    }

    /**
     * Get an array of all tooltips.
     *
     * @return array An array of Tooltip objects.s
     */
    public function getTooltips() : array {
        $sqlQuery = 'SELECT * FROM tooltips';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[$row['hint_id']] = new Tooltip($row);
        }

        return $dataSet;
    }
}