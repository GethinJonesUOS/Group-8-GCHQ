<?php


require_once('Models/Users.php');

$view = new stdClass();

$view->pageTitle = 'EMail';

include_once('Views/email.phtml');