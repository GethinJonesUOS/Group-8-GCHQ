<?php

require_once('Models/Tests.php');


$view = new stdClass();
$view->pageTitle = 'Webbrowser';

$tests = new Tests();

$view->scripts = ['/js/webbrowser.js'];

//if session terminated and user is no longer logged in will be redirected to the login page
if (!isLoggedIn()) {
    header('location: /login.php');
    exit;
}

//If test results submitted
if (isset($_POST['browser1'], $_POST['browser2'], $_POST['browser3'], $_POST['browser4'])) {

    $result = 0;

    if ($_POST['browser1'] == 'LinkedIn') {
        $result += 25;
    }
    if ($_POST['browser2'] == 'PayPal') {
        $result += 25;
    }
    if ($_POST['browser3'] == 'Currys.co.uk/Mac') {
        $result += 25;
    }
    if ($_POST['browser4'] == 'Currys.co.uk/checkout') {
        $result += 25;
    }

    //associative array = abstract data type composed of a collection of (key, value) pairs
    $data = [
        'test_name' => 'Website Test',
        'result' => $result
    ];

    //call to addResults method in Tests and pass the array
    $view->tests = $tests->addResults($data);
    header('location: /profile.php');

} else {
    $data = [
        'user_email' => '',
        'test_name' => '',
        'result' => ''
    ];
}


require_once('Views/webbrowser.phtml');
