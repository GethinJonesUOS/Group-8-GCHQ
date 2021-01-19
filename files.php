<?php

require_once 'Models/Users.php';
require_once 'Models/Tooltips.php';
require_once 'Models/Files.php';

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
} else if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'getfiles':
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
    }
} else {
    $view = new stdClass();
    $view->pageTitle = 'File Browsers';
    $view->scripts = ['/js/files.js'];

    include_once 'Views/files.phtml';
}