<?php

require_once 'Models/Users.php';
require_once 'Models/Tests.php';

if (isset($_POST['action'])) {

} else {
    $view = new stdClass();
    $view->pageTitle = 'File Browsers';
    $view->scripts = ['/js/files.js'];

    include_once 'Views/files.phtml';
}