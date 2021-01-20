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
        'password' => ''
    ];

    //Sanitize post data. Prevent sql injection
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //trimming data
    $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password'])
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

require_once('Views/login.phtml');