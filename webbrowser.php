<?php

require_once('Models/Tests.php');


$view = new stdClass();
$view->pageTitle = 'Webbrowser';

$tests = new Tests();

$view = new stdClass();
$view->pageTitle = 'Email';
$view->scripts = ['/js/webbrowser.js'];

if (!isLoggedIn()) {
    header('location: /login.php');
    exit;
}

//If login request submitted
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

    //call to registerValidation method in Users and pass the array
    $view->tests = $tests->addResluts($data);

} else {
    $data = [
        'user_email' => '',
        'test_name' => '',
        'result' => ''
    ];
}


require_once('Views/webbrowser.phtml');
