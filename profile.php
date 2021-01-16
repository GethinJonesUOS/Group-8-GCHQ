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
}

require_once('Views/profile.phtml');