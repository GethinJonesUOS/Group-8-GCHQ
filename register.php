<?php

require_once('Models/Users.php');


$view = new stdClass();
$view->pageTitle = 'Register';

$users = new Users();

//If login request submitted
if (isset($_POST['email'], $_POST['password'])) {

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        'email' => '',
        'password' => '',
        'firstname' => '',
        'lastname' => '',
        'confirmPassword' => '',
        'emailError' => '',
        'passwordError' => '',
        'confirmPasswordError' => ''
    ];

    //Sanitize post data. Prevent sql injection
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //trimming the data
    $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'firstname' => trim($_POST['firstname']),
        'lastname' => trim($_POST['lastname']),
        'confirmPassword' => trim($_POST['confirmPassword']),
        'emailError' => '',
        'passwordError' => '',
        'confirmPasswordError' => ''
    ];

    //call to registerValidation method in Users and pass the array
    $view->users = $users->registerValidation($data);

    $emailError = $_POST['emailError'];
    $passwordError = $_POST['passwordError'];
    $confirmPasswordError = $_POST['confirmPasswordError'];

    $errorArray = array();

    if (!empty($data['emailError'])) {
        $errorArray = $data['emailError'];
    }

    if (!empty($data['emailError'])) {
        $errorArray = $data['emailError'];
    }
    if (!empty($data['passwordError'])) {
        $errorArray = $data['passwordError'];
    }
    if (!empty($data['confirmPasswordError'])) {
        $errorArray = $data['confirmPasswordError'];
    }

    if (count($errorArray) > 0) {
        foreach ($errorArray AS $Error) {
            echo "<font color='red'><b>".$Error."</font></b><br>";
        }
    }

} else {
    $data = [
        'email' => '',
        'password' => '',
        'firstname' => '',
        'lastname' => '',
        'conformPassword' => '',
        'emailError' => '',
        'passwordError' => '',
        'confirmPasswordError' => ''
    ];
}



////Return $data in case of error
//if ($data['emailError']) {
//    echo $data['emailError'];
//} elseif ($data['passwordError']) {
//    echo $data['passwordError'];
//} elseif ($data['confirmPasswordError']) {
//    echo $data['confirmPasswordError'];
//} else {
//    $data = [
//        'email' => '',
//        'password' => '',
//        'firstname' => '',
//        'lastname' => '',
//        'conformPassword' => '',
//        'emailError' => '',
//        'passwordError' => '',
//        'confirmPasswordError' => ''
//    ];
//}

require_once('Views/register.phtml');