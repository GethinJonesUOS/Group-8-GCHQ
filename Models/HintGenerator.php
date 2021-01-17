<?php


class HintGenerator {

    protected $_text;
    protected $_tooltips;

    /**
     * HintGenerator constructor.
     *
     * @param $text
     */
    public function __construct($text) {
        $this->_text = $text;
        $this->_tooltips = [];
    }

    /**
     * @return string
     */
    public function transform() : string {
        $hintPos = 0;
        $sectionStart = 0;
        $sections = [];
        $eof = false;
        while (!$eof) {
            $hintPos = strpos($this->_text, 'hint', $hintPos);
            if ($hintPos == false) {
                $textEnd = strlen($this->_text) - 1;
                $sections[] = substr($this->_text, $sectionStart, $textEnd - $sectionStart + 1);
                $eof = true;
            } else {
                $tagStart = $this->getTagStart($hintPos);
                $tagEnd = $this->getTagEnd($hintPos);
                $sections[] = substr($this->_text, $sectionStart, $tagStart - $sectionStart);

                $tag = substr($this->_text, $tagStart, $tagEnd - $tagStart);
                $sections[] = $this->transformTag($tag);

                $hintPos = $sectionStart = $tagEnd;
            }
        }

        return implode($sections);
    }

    /**
     * @param $id
     * @param $text
     */
    public function addTooltip($id, $text) {
        $this->_tooltips[$id] = $text;
    }

    private function getTagStart($pos) {
        $found = false;
        while (!$found) {
            $charAtPos = substr($this->_text, $pos, 1);
            if ($charAtPos == '<') {
                $found = true;
            } else {
                $pos--;
            }

            if ($pos == -1) {
                break;
            }
        }

        return $pos;
    }

    private function getTagEnd($pos) {
        return strpos($this->_text, '>', $pos) + 1;
    }

    private function transformTag($tag) {
        $tagSections = [];

        $hintId = $this->getHintId($tag);
        $hint = $this->_tooltips[$hintId];

        $tagSections[] = substr($tag, 0, strlen($tag) - 1);
        $tagSections[] = "title=\"$hint\"";

        if ($this->hasAttribute($tag, "url")) {
            $tagSections[] = "class=\"link\"";
        }

        $tagSections[] = ">";
        return implode(" ", $tagSections);
    }

    private function hasAttribute($tag, $attribute) : bool {
        return strpos($tag, $attribute, 0) != false;
    }

    private function getHintId($tag) {
        $attribPos = strpos($tag, 'hint-id="', 0);
        $valueEnd = $valueStart = $attribPos + 9;
        $done = false;
        while (!$done) {
            $idValue = substr($tag, $valueEnd, 1);
            if (is_numeric($idValue)) {
                $valueEnd++;
            } else {
                $done = true;
            }
        }

        return substr($tag, $valueStart, $valueEnd - $valueStart);
    }
}