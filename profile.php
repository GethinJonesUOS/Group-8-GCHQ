<?php

require_once('Models/Users.php');

$view = new stdClass();
$view->pageTitle = 'Profile Page';


$userData = new Users();

if (isLoggedIn()) {
    $user_id = (int)$_SESSION['user_id'];

    //send data to set new bid of valid
    $view->userData = $userData->getUserInfo($user_id);
}

require_once('Views/profile.phtml');