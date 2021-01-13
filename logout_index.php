<?php

require_once('Models/Users.php');

$view = new stdClass();
$view->pageTitle = 'Logout';

$users = new Users();

//End cookie session
$view->users = $users->logout();

header('location: /desktop.php');

require_once('Views/logout_index.phtml');