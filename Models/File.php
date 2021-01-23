<?php


class File {
    protected $_id;
    protected $_fileName;
    protected $_content;
    protected $_action;
    protected $_tooltip;
    protected $_icon;

    /**
     * file constructor.
     *
     * @param $row
     */
    public function __construct($row) {
        $this->_id = $row['id'];
        $this->_fileName = $row['filename'];
        $this->_content = $row['content'];
        $this->_action = $row['action'];
        $this->_tooltip = $row['tooltip_id'];
        $this->_icon = $row['icon'];
    }

    /**
     * Get the File's table id.
     *
     * @return int The file's table id.
     */
    public function getId() : int {
        return $this->_id;
    }

    /**
     * A number corresponding to the action the should take when
     * the file is activated.
     *
     * @return int The UI action associated to the file.
     */
    public function getAction() : int {
        return $this->_action;
    }

    /**
     * Get the contents of the file.
     *
     * @return string The file's contents.
     */
    public function getContent() : string {
        return $this->_content;
    }

    /**
     * Get the name of the file.
     *
     * @return string The name of the file.
     */
    public function getFileName() : string {
        return $this->_fileName;
    }

    /**
     * The table ID of the file's tooltip
     *
     * @return int The file's tooltip ID.
     */
    public function getTooltipID() : int {
        return $this->_tooltip;
    }

    /**
     * The file name of the file's icon.
     *
     * @return string The name of the icon image file.
     */
    public function getIcon() : string {
        return $this->_icon;
    }

    /**
     * Return the object a JSON string. Excludes content.
     *
     * @return string The object as a JSON string.
     */
    public function json_encode() : string {
        $id = $this->_id;
        $fileName = $this->_fileName;
        $action = $this->_action;
        $icon = $this->_icon;

        return "{\"id\": \"$id\", \"fileName\": \"$fileName\", \"icon\": \"$icon\", \"action\": \"$action\"}";
    }

}