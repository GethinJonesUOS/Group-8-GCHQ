<?php

require_once 'Views/template/session_helper.php';
require_once 'Models/Database.php';
require_once 'Models/User.php';

class Users
{

    protected $_dbHandle, $_dbInstance;


    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getDbConnection();
    }

    /* Validating registrant details */
    public function registerValidation($data) {

        $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

        $errors = [
            'emailError' => '',
            'firstnameError' => '',
            'lastnameError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ];

        //Validate email
        if (empty($data['email'])) {
            $errors['emailError'] = 'Please enter email address.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['emailError'] = 'Please enter the correct format.';
        } else {
            //Check if email exist
            if ($this->findUserByEmail($data['email'])) {
                $errors['emailError'] = 'Email already exist.';
            }
        }

        //Validate firstname
        if(empty($data['firstname'])) {
            $errors['firstnameError'] = 'Please enter your name.';
        }

        //Validate lastname
        if(empty($data['lastname'])) {
            $errors['lastnameError'] = 'Please enter your surname.';
        }

        //Validate possword length, numeric values
        if(empty($data['password'])) {
            $errors['passwordError'] = 'Please enter password.';
        } elseif (strlen($data['password']) < 6) {
            $errors['passwordError'] = 'Password must be at least 8 characters.';
        } elseif (preg_match($passwordValidation, $data['password'])) {         //$passwordValidation <--
            $errors['passwordError'] = 'Password must have at least one numeric value';
        }

        //Validate confirm password
        if (empty($data['confirmPassword'])) {
            $errors['confirmPasswordError'] = 'Please enter password';
        } elseif ($data['password'] != $data['confirmPassword']) {
            $errors['confirmPasswordError'] = 'Passwords do not match, please try again.';
        }

        // Ensuring there are no errors
        if (empty($errors['emailError']) && empty($errors['passwordError']) && empty($errors['confirmPasswordError'])) {

            //Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $this->register($data);
        } else {
            return $errors;
        }
    }

    /* If validation passed, user will be poassed to register method */
    public function register($data) {

        $temp = 'blank-profile-picture.png';

        //Inserting values to the user table
        $sqlQuery1 = ("INSERT INTO users (email, password, first_name, last_name, image) VALUES ( :email_ins, :password_ins, :firstname_ins, :lastname_ins, :image_ins)");
        $statement1 = $this->_dbHandle->prepare($sqlQuery1); // prepare a PDO statement
        $statement1->bindParam(':email_ins', $data['email']);  //binding all needed parameters
        $statement1->bindParam(':password_ins', $data['password']);
        $statement1->bindParam(':firstname_ins', $data['firstname']);
        $statement1->bindParam(':lastname_ins', $data['lastname']);
        $statement1->bindParam(':image_ins', $temp);
        $statement1->execute(); // execute the PDO statement

        if ($this->findUserByEmail($data['email'])) {
            header('location: /login.php');
        }
    }

    /* Validating login details */
    public function loginValidation($data) {

        $errors = [
            'emailError' => '',
            'passwordError' => ''
        ];

        //Validate email
        if (empty($data['email'])) {
            $errors['emailError'] = 'Please enter email.';
        }

        //Validate password
        if (empty($data['password'])) {
            $errors['passwordError'] = 'Please enter password.';
        }

        //Check if all errors are empty
        if(empty($errors['emailError']) && empty($errors['passwordError'])) {
            //$loggedInUser = $this->login($data['email'], $data['password']);

            $user = $this->login($data);

            if (empty($user)) {
                $user = null;
                $errors['emailError'] = 'Email do not exist. Please try again!';
                return $errors;
            } else {
                //Verifying password
                $hashedPassword = $user->getPassword();

                if (password_verify($data['password'], $hashedPassword)) {
                    $this->createUserSession($user);
                    header('location: /index.php');

                } else {
                    print_r($errors);
                    //$user = null;
                    $errors['passwordError'] = 'Email or password is incorrect. Please try again.';
                    print_r($errors);
                    return $errors;
                }
            }
        } else {
            return  $errors;
        }
    }

    /* Login method */
    public function login($data) {

        $errors = [
            'emailError' => '',
            'passwordError' => ''
        ];

        $sqlQuery = ("SELECT * FROM users WHERE email = :email");

        //Execute the query
        try
        {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->bindParam(':email', $data['email']);
            $statement->execute(); // execute the PDO statement
        }
        catch (PDOException $e)
        {
            //If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }

        $row = $statement->fetch();

        if ($row > 0) {
            $user = new User($row);
        }

        return $user;
    }

    /* Get user information */
    public function getUserInfo($user_id) {

        $sqlQuery = ("SELECT * FROM users WHERE id = :user_id");

        //Execute the query
        try
        {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->bindParam(':user_id', $user_id);
            $statement->execute(); // execute the PDO statement
        }
        catch (PDOException $e)
        {
            //If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }

        $row = $statement->fetch();
        $user[] = new User($row);

        return $user; //TODO: This function needs to return an object, not an array
    }

    /* Find user by email */
    public function findUserByEmail($email) {

        //Prepare statement
        $sqlQuery = 'SELECT * FROM users WHERE email = :_email';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':_email', $email);
        $statement->execute(); // execute the PDO statement

        if ($statement->fetch() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /* Create new session */
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->getUserID();
        $_SESSION['email'] = $user->getEmail();
    }

    /* Delete current session */
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
    }
}