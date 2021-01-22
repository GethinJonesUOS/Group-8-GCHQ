<?php

require_once 'Views/template/session_helper.php';

if (!isLoggedIn()) {
    header('location: /login.php');
    exit;
}

require_once('Models/Users.php');

$view = new stdClass();

$view->pageTitle = 'Desktop';

include_once('Views/desktop.phtml');