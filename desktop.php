<?php

require_once('Models/Users.php');

$view = new stdClass();

$view->pageTitle = 'Desktop';

include_once('Views/desktop.phtml');