<?php


class File {
    protected $_id;
    protected $_fileName;
    protected $_content;
    protected $_isDangerous;
    protected $_action;
    protected $_tooltip;

    /**
     * file constructor.
     *
     * @param $row
     */
    public function __construct($row) {
        $this->_id = $row['id'];
        $this->_fileName = $row['filename'];
        $this->_content = $row['content'];
        $this->_isDangerous = $row['is_dangerous'];
        $this->_action = $row['action'];
        $this->_tooltip = $row['tooltip_id'];
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getAction() {
        return $this->_action;
    }

    /**
     * @return string
     */
    public function getContent() : string {
        return $this->_content;
    }

    /**
     * @return string
     */
    public function getFileName() : string {
        return $this->_fileName;
    }

    /**
     * @return mixed
     */
    public function getIsDangerous() : bool {
        return $this->_isDangerous;
    }

    /**
     * @return mixed
     */
    public function getTooltipID() {
        return $this->_tooltip;
    }

    /**
     * @return string
     */
    public function json_encode() : string {
        $id = $this->_id;
        $fileName = $this->_fileName;
        $content = $this->_content;
        $isDangerous = $this->_isDangerous;
        $action = $this->_action;

        return "{\"id\": \"$id\", \"fileName\": \"$fileName\"}";
    }

}