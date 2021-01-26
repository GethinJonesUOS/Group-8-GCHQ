<?php

require_once('Models/Users.php');
require_once('Models/Tests.php');

$view = new stdClass();
$view->pageTitle = 'Profile Page';

$userData = new Users();
$testData = new Tests();

if (isLoggedIn()) {
    $user_id = (int)$_SESSION['user_id'];
    
    $view->userData = $userData->getUserInfo($user_id);

    $view->testData = $testData->getResults();
} else {
    //if session terminated and user is no longer logged in will be redirected to the login page
    header('location: /login.php');
}

//If email change request submitted
if (isset($_POST['email-emailChange'], $_POST['password-emailChange'], $_POST['changeEmail'])) {

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        'email' => '',
        'password' => ''
    ];

    //Sanitize post data. Prevent sql injection
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //trimming data
    $data = [
        'email' => trim($_POST['email-emailChange']),
        'password' => trim($_POST['password-emailChange'])
    ];


    //call to email change validation method in Users and pass the array
    $view->returnData = $userData->changeEmailValidation($data);

    $data = null;

    //If password change request submitted
} elseif (isset($_POST['newPassword-passwordChange'], $_POST['confirmNewPassword-passwordChange'], $_POST['oldPassword-passwordChange'], $_POST['changePassword'])) {

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        'newPassword' => '',
        'confirmNewPassword' => '',
        'oldPassword' => ''
    ];

    //Sanitize post data. Prevent sql injection
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //trimming data
    $data = [
        'newPassword' => trim($_POST['newPassword-passwordChange']),
        'confirmNewPassword' => trim($_POST['confirmNewPassword-passwordChange']),
        'oldPassword' => trim($_POST['oldPassword-passwordChange']),
    ];


    //call to password change validation method in Users and pass the array
    $view->returnData = $userData->changePasswordValidation($data);

    $data = null;

    //If delete account request submitted
} elseif (isset($_POST['reply'], $_POST['pass'], $_POST['deleteAccount'])) {

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        'reply' => '',
        'pass' => ''
    ];

    //Sanitize post data. Prevent sql injection
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //trimming data
    $data = [
        'reply' => trim($_POST['reply']),
        'pass' => trim($_POST['pass'])
    ];


    //call to login validation method in Users and pass the array
    $view->returnData = $userData->deleteAccountValidation($data);

    $data = null;

} else {

    $data = null;
}

require_once('Views/profile.phtml');