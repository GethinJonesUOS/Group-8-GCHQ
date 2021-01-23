<?php


class Tooltip {

    protected $_tooltipId;
    protected $_text;

    /**
     * Tooltip constructor.
     *
     * @param $row An array containing values for 'id' and 'text' of the tooltip.
     */
    public function __construct($row) {
        $this->_tooltipId = $row['hint_id'];
        $this->_text = $row['text'];
    }

    /**
     * Get the ID of the tooltip.
     *
     * @return int The tooltip's ID.
     */
    public function getId() : int {
        return $this->_tooltipId;
    }

    /**
     * Get the text of the tooltip.
     *
     * @return string The tooltip's text.
     */
    public function getText() : string {
        return $this->_text;
    }
}