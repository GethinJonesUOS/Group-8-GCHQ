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
     * @return mixed
     */
    public function getId() {
        return $this->_tooltipId;
    }

    /**
     * Get the text of the tooltip.
     *
     * @return mixed
     */
    public function getText() {
        return $this->_text;
    }
}