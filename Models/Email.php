<?php


class Email {
    protected $_id;
    protected $_from;
    protected $_subject;
    protected $_body;
    protected $_isPhishing;
    protected $_userAnswer;

    /**
     * Email constructor.
     * @param $row An array containing values for 'id', 'from', 'subject', 'body' and 'isPhishing';
     */
    public function __construct($row) {
        $this->_id = $row['id'];
        $this->_from = $row['from'];
        $this->_subject = $row['subject'];
        $this->_body = $row['body'];
        $this->_isPhishing = $row['isPhishing'];
        $this->_userAnswer = '';
    }

    /**
     * Get the unique ID of the email.
     *
     * @return mixed
     */
    public function getID() {
        return $this->_id;
    }

    /**
     * Get the sender of the email.
     *
     * @return mixed
     */
    public function getFrom() {
        return $this->_from;
    }

    /**
     * Get the subject of the email.
     *
     * @return mixed
     */
    public function getSubject() {
        return $this->_subject;
    }

    /**
     * Get the body of the email.
     *
     * @return mixed
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * Returns true if the email is a phishing email.
     *
     * @return bool
     */
    public function isPhishing() : bool {
        return $this->_isPhishing == 1;
    }

    /**
     * Get the user's selected answer to this email
     *
     * @return string
     */
    public function getUserAnswer() : string {
        return $this->_userAnswer;
    }

    /**
     * @return bool
     */
    public function checkAnswer() : bool {
        return ($this->isPhishing() && $this->_userAnswer == 'phishing') ||
            (!$this->isPhishing() && $this->_userAnswer == 'real');
    }

    /**
     * Set the user's selected answer to this email
     *
     * @param $value
     */
    public function setUserAnswer($value) {
        $this->_userAnswer = $value;
    }
}