<?php

require_once 'Models/Users.php';
require_once 'Models/Tooltips.php';
require_once 'Models/Files.php';
require_once 'Models/Tests.php';

// Redirect to login page if request is received without logged in session
if (!isLoggedIn()) {
    header('location: /login.php');
    exit;
}

// Requests with a GET action parameter
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'filecontent':
            if (isset($_GET['filename'])) {
                $filesDataSet = new Files();
                $file = $filesDataSet->getFileFromName($_GET['filename']);
                echo $file->getContent();
            }
            break;
    }
    // Requests with a POST action parameter
} else if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'getfiles': // Return a json object containing Files data
            $filesDataSet = new Files();
            $files = $filesDataSet->getFilesList();

            $tooltipsData = new Tooltips();
            $tooltips = $tooltipsData->getTooltips();

            $filesArr = [];
            $tooltipsArr = [];
            foreach ($files as $file) {
                $filesArr[] = $file->json_encode();
                $tooltip = $tooltips[$file->getTooltipID()]->getText();
                $tooltipsArr[] = '"' . $tooltip . '"';
            }
            header('Content-Type: application/json');
            echo '{"files": [' . implode(',', $filesArr) . '], "tooltips": [' . implode(',', $tooltipsArr) . ']}';
            break;
        case 'submitscore': // Submit the user's score to the database and redirect to the profile page
            if (isset($_POST['score'])) {
                $tests = new Tests();
                $result = ['test_name' => 'Files Test', 'result' => $_POST['score']];
                $tests->addResults($result);
                header('location: /profile.php');
            } else {
                header('location: /');
            }
            break;
        case 'gettutorstatus':
            $skip = 'false';
            if (isset($_SESSION['files_tutor'])) {
                if ($_SESSION['files_tutor'] == 'skip') {
                    $skip = 'true';
                }
            }

            echo '{"skipFileTutor": ' . $skip . '}';
            break;
        case 'settutorstatus':
            if ($_POST['status']) {
                $_SESSION['files_tutor'] = $_POST['status'];
            } else {
                http_response_code(403);
                die('Forbidden');
            }
            break;
        default:
            echo 'Error: Bad request';
    }
} else {
    // If no parameters are provided, show the Files view.
    $view = new stdClass();
    $view->pageTitle = 'File Browsers';
    $view->scripts = ['/js/files.js'];

    include_once 'Views/files.phtml';
}