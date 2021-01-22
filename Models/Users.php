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

        $passwordValidation = "/^([^A-Z]*|[^a-z]*|[^\d]*)$/i";
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
        } elseif (strlen($data['password']) < 8) {
            $errors['passwordError'] = 'Password must be at least 8 characters.';
        } elseif (preg_match($passwordValidation, $data['password'])) {
            $errors['passwordError'] = 'Password must contain: numeric value & capital letter.';
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
                    $user = null;
                    $errors['passwordError'] = 'Email or password is incorrect. Please try again.';
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

    /* Change email validation */
    public function changeEmailValidation($data) {

        $returnData = [
            'emailError' => '',
            'passwordError' => '',
            'successMsg' => ''
        ];

        //Validate email
        if (empty($data['email'])) {
            $returnData['emailError'] = 'Please enter email.';
        }

        if ($this->findUserByEmail($data['email'])) {
            $returnData['emailError'] = 'Email already exists.';
        }

        //Validate password
        if (empty($data['password'])) {
            $returnData['passwordError'] = 'Please enter password.';
        }

        //Check if all errors are empty
        if (empty($returnData['emailError']) && empty($returnData['passwordError'])) {

            if ($this->passwordAuthentication($data['password'])) {
                $this->changeEmail($data);
                $returnData['successMsg'] = 'Email successfully changed.';
            } else {
                $returnData['passwordError'] = 'Wrong password. Please try again.';
            }
        }
        return $returnData;
    }

    /* Change user email */
    public function changeEmail($data) {

        $sqlQuery = ("UPDATE users SET email = :email WHERE id = :user_id");

        //Execute the query
        try
        {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->bindParam(':email', $data['email']);
            $statement->bindParam(':user_id', $_SESSION['user_id']);
            $statement->execute(); // execute the PDO statement

            $_SESSION['email'] = $data['email'];
        }
        catch (PDOException $e)
        {
            //If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }
    }

    /* Change password validation */
    public function changePasswordValidation($data) {

        $returnData = [
            'newPasswordError' => '',
            'newPasswordConfirmationError' => '',
            'oldPasswordError' => '',
            'passSuccessMsg' => ''
        ];

        $passwordValidation = "/^([^A-Z]*|[^a-z]*|[^\d]*)$/i";

        if (empty($data['newPassword'])) {
            $returnData['newPasswordError'] = 'Please enter your new password.';
        } elseif (strlen($data['oldPassword']) < 8) {
            $returnData['newPasswordError'] = 'Password must be at least 8 characters.';
        } elseif (preg_match($passwordValidation, $data['newPassword'])) {
            $returnData['newPasswordError'] = 'Password must contain: numeric value & capital letter.';
        }

        if (empty($data['confirmNewPassword'])) {
            $returnData['newPasswordConfirmationError'] = 'Please confirm your password.';
        } elseif ($data['newPassword'] != $data['confirmNewPassword']) {
            $returnData['newPasswordConfirmationError'] = 'Passwords do not match, please try again.';
        }

        if (empty($data['oldPassword'])) {
            $returnData['oldPasswordError'] = 'Please enter your old password.';
        } elseif (!$this->passwordAuthentication($data['oldPassword'])) {
            $returnData['oldPasswordError'] = 'Wrong password. Please try again';
        }

        //Check if all errors are empty
        if (empty($returnData['newPasswordError']) && empty($returnData['newPasswordConfirmationError']) && empty($returnData['oldPasswordError'])) {

            $password = password_hash($data['newPassword'], PASSWORD_DEFAULT);

            $this->changePassword($password);
            $returnData['PassSuccessMsg'] = 'Password successfully changed.';

        }
        return $returnData;
    }

    /* Change password */
    public function changePassword($password) {

        $sqlQuery = ("UPDATE users SET password = :password WHERE id = :user_id");

        //Execute the query
        try
        {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->bindParam(':password', $password);
            $statement->bindParam(':user_id', $_SESSION['user_id']);
            $statement->execute(); // execute the PDO statement
        }
        catch (PDOException $e)
        {
            //If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }
    }

    /* Delete account validation */
    public function deleteAccountValidation($data) {

        $returnData = [
            'replyError' => '',
            'passError' => ''
        ];

        if (empty($data['reply'])) {
            $returnData['replyError'] = 'Please tell us why you decided to delete your account.';
        } elseif (strlen($data['reply']) > 150 || strlen($data['reply']) < 10) {
            $returnData['replyError'] = 'Your reply can not be less than 10 nor exceed 150 characters.';
        }

        if (empty($data['pass'])) {
            $returnData['passError'] = 'Please enter your password.';
        } elseif (!$this->passwordAuthentication($data['pass'])) {
            $returnData['passError'] = 'Wrong password. Please try again';
        }

        //Check if all errors are empty
        if (empty($returnData['replyError']) && empty($returnData['passError'])) {

            $this->deleteAccount();
            header('location: /login.php');

        } else {
            return $returnData;
        }
    }

    /* Change password*/
    public function deleteAccount() {

        $sqlQuery = ("DELETE FROM users WHERE id = :user_id");

        //Execute the query
        try
        {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->bindParam(':user_id', $_SESSION['user_id']);
            $statement->execute(); // execute the PDO statement
        }
        catch (PDOException $e)
        {
            //If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }
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

    /* authintication */
    public function passwordAuthentication($password) {

        //Prepare statement
        $sqlQuery = 'SELECT * FROM users WHERE email = :_email';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(':_email', $_SESSION['email']);
        $statement->execute(); // execute the PDO statement

        $row = $statement->fetch();
        $user = new User($row);

        $hashedPassword = $user->getPassword();

        if (password_verify($password, $hashedPassword)) {
            return true;
        } else {
            $user = null;
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