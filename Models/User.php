<?php

class User {

    //Instantiating variables
    protected  $_id, $_email, $_password, $_firstname, $_lastname, $_user_image, $_address;

    //Constructor
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_email = $dbRow['email'];
        $this->_password = $dbRow['password'];
        $this->_firstname = $dbRow['first_name'];
        $this->_lastname = $dbRow['last_name'];
        //if ($dbRow['image']) $this->_user_image = 'yes'; else $this->_user_image = 'no';
        $this->_image = $dbRow['image'];
        $this->_address = $dbRow['address_id'];
        //$this->_postcode = $dbRow['postcode'];
    }

    //Get methods to access
    public function getUserID() {
        return $this->_id;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getFirstName() {
        return $this->_firstname;
    }

    public function getLastName() {
        return $this->_lastname;
    }

    public function getUserImage() {
        return $this->_user_image;
    }

    public function getUserAddress() {
        return $this->_address;
    }

    public function getUserPostcode() {
        return $this->_postcode;
    }
}