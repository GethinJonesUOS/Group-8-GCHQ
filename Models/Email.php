<?php


class Email {
    protected $_id;
    protected $_from;
    protected $_fromName;
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
        $this->_fromName = $row['from_name'];
        $this->_subject = $row['subject'];
        $this->_body = $row['body'];
        $this->_isPhishing = $row['isPhishing'];
        $this->_userAnswer = '';
    }

    /**
     * Get the unique ID of the email.
     *
     * @return int The email's id.
     */
    public function getID() : int {
        return $this->_id;
    }

    /**
     * Get the from address of the email.
     *
     * @return string The email's from address.
     */
    public function getFrom() :string {
        return $this->_from;
    }

    /**
     * Get the name of the email sender.
     *
     * @return string The name of the sender.
     */
    public function getFromName() : string {
        return $this->_fromName;
    }

    /**
     * Get the subject of the email.
     *
     * @return string The email's subject.
     */
    public function getSubject() : string {
        return $this->_subject;
    }

    /**
     * Get the body of the email.
     *
     * @return string The body of the email.
     */
    public function getBody() : string {
        return $this->_body;
    }

    /**
     * Returns true if the email is a phishing email.
     *
     * @return bool True if email is a phishing email, otherwise false.
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
     * Check if the answer provided by the user matches the correct answer.
     *
     * @return bool True the user's answer is correct otherwise false.
     */
    public function checkAnswer() : bool {
        return ($this->isPhishing() && $this->_userAnswer == 'phishing') ||
            (!$this->isPhishing() && $this->_userAnswer == 'real');
    }

    /**
     * Set the user's selected answer to this email
     *
     * @param $value String, either 'phishing' or 'real'.
     */
    public function setUserAnswer($value) {
        $this->_userAnswer = $value;
    }

    /**
     * DO NOT USE! Needs work. TODO: create custom JSON string
     * Return the object as a JSON string.
     *
     * @return string Object as a JSON string.
     */
    public function json_encode() : string {
        $obj = new stdClass();
        $obj->id = $this->_id;
        $obj->from = $this->_from;
        $obj->fromName = $this->_fromName;
        $obj->subject = $this->_subject;
        $obj->isPhishing = $this->_isPhishing;
        $obj->userAnswer = $this->_userAnswer;

        return $this->json_encode($obj);
    }
}