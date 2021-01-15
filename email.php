<?php


require_once 'Models/Users.php';
require_once 'Models/Emails.php';
require_once 'Models/HintGenerator.php';
require_once 'Models/Tooltips.php';

$emailsData = new Emails();

$view = new stdClass();

if (isset($_GET['selected'])) {
    $selectedEmail = $emailsData->getEmail($_GET['selected']);
} else {
    $selectedEmail = null;
}

$view->pageTitle = 'Email';
$view->emails = $emailsData->getEmails();
$view->selectedEmail = $selectedEmail;

if (isset($view->selectedEmail)) {
    $hintGenerator = new HintGenerator($view->selectedEmail->getBody());
    $tooltips = new Tooltips();
    $toolTipsData = $tooltips->getTooltips();

    foreach ($toolTipsData as $tooltip) {
        $hintGenerator->addTooltip($tooltip->getId(), $tooltip->getText());
    }

    $view->transformedBody = $hintGenerator->transform();
}

include_once('Views/email.phtml');