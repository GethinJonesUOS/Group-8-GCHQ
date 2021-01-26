<?php

class User {

    /**
     *Instantiating variables
     * @var id,
     * @var email
     * @var password
     * @var firstname
     * @var lastname
     * @var image
     */

    protected  $_id, $_email, $_password, $_firstname, $_lastname, $_user_image;

    /**
     * Costructor function for type "User"
     * @param database array
     *
     */
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_email = $dbRow['email'];
        $this->_password = $dbRow['password'];
        $this->_firstname = $dbRow['first_name'];
        $this->_lastname = $dbRow['last_name'];
        $this->_image = $dbRow['image'];
    }

    /**
     * Accessors Method
     * @return id
     */
    public function getUserID() {
        return $this->_id;
    }

    /**
     * @return email
     */
    public function getEmail() {
        return $this->_email;
    }

    /**
     * @return password
     */
    public function getPassword() {
        return $this->_password;
    }

    /**
     * @return firstname
     */
    public function getFirstName() {
        return $this->_firstname;
    }

    /**
     * @return lastname
     */
    public function getLastName() {
        return $this->_lastname;
    }

    /**
     * @return image
     */
    public function getUserImage() {
        return $this->_user_image;
    }
}