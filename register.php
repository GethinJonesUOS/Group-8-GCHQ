<?php

require_once('Models/Users.php');


$view = new stdClass();
$view->pageTitle = 'Register';

$users = new Users();

//If register form submitted
if (isset($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['password'], $_POST['confirmPassword'])) {

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        'email' => '',
        'password' => '',
        'firstname' => '',
        'lastname' => '',
        'confirmPassword' => ''
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
    ];

    //call to registerValidation method in Users and pass the array
    $view->users = $users->registerValidation($data);
} else {
    $data = [
        'email' => '',
        'password' => '',
        'firstname' => '',
        'lastname' => '',
        'conformPassword' => ''
    ];
}

require_once('Views/register.phtml');