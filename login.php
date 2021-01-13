<?php

require_once('Models/Users.php');

$view = new stdClass();
$view->pageTitle = 'Login';

$users = new Users();

//If login request submitted
if (isset($_POST['email'], $_POST['password'])) {

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        //'title' => 'Login page',
        'email' => '',
        'password' => '',
        'emailError' => '',
        'passwordError' => ''
    ];

    //Sanitize post data. Prevent sql injection
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //trimming data
    $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'emailError' => '',
        'passwordError' => ''
    ];


    //call to login validation method in Users and pass the array
    $view->users = $users->loginValidation($data);

} else {
    $data = [
        'email' => '',
        'password' => '',
        'emailError' => '',
        'passwordError' => ''
    ];
}

//Return $data in case of error
if ($data['emailError']) {
    echo $data['emailError'];
} elseif ($data['passwordError']) {
    echo $data['passwordError'];
} else {
    $data = [
        'email' => '',
        'password' => '',
        'firstname' => '',
        'lastname' => '',
        'address' => '',
        'postcode' => '',
        'conformPassword' => '',
        'emailError' => '',
        'passwordError' => '',
        'confirmPasswordError' => ''
    ];
}

require_once('Views/login.phtml');