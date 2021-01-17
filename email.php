<?php

require_once 'Models/Users.php';
require_once 'Models/Emails.php';
require_once 'Models/HintGenerator.php';
require_once 'Models/Tooltips.php';
require_once 'Models/Tests.php';

if (!isLoggedIn()) {
    header('location: /index.php');
    exit;
}

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == true) {
        $answerCount = count($_SESSION['email_answers']);
        $correctAnswerCount = 0;

        $emailsData = new Emails();
        $emails = $emailsData->getEmails();
        $emailCount = count($emails);

        if ($answerCount == $emailCount) {
            foreach ($emails as $email) {
                $email->setUserAnswer($_SESSION['email_answers'][$email->getID()]);
                if ($email->checkAnswer()) {
                    $correctAnswerCount++;
                }
            }

            $score = round($correctAnswerCount / $emailCount * 100, 0);

            $tests = new Tests();
            $result = ['test_name' => 'Email Test', 'result' => $score];
            $tests->addResluts($result);
            header('location: /profile.php');
            exit;
        } else {
            echo 'An unexpected error has occured.';
            exit;
        }
    }
} else if (isset($_POST['getscroll'])) {
    if (isset($_SESSION['email_scroll_pos'])) {
        $scrollPos = $_SESSION['email_scroll_pos'];
    } else {
        $scrollPos = 0;
    }

    header('Content-Type: application/json');
    echo "{\"scrollPos\": $scrollPos}";
} else if (isset($_POST['setscroll'])) {
    $_SESSION['email_scroll_pos'] = $_POST['setscroll'];
} else {

    $view = new stdClass();
    $view->pageTitle = 'Email';
    $view->scripts = ['/js/email.js'];

    if (isset($_POST['reset']) && $_POST['reset'] == 'true') {
        unset($_SESSION['email_answers']);
        $_SESSION['email_scroll_pos'] = 0;
    }

    if (!isset($_SESSION['email_answers'])) {
        $_SESSION['email_answers'] = [];
    }

    $emailsData = new Emails();

    if (isset($_GET['selected'])) {
        $selectedEmail = $emailsData->getEmail($_GET['selected']);
        if (isset($_SESSION['email_answers'][$selectedEmail->getID()])) {
            $selectedEmail->setUserAnswer($_SESSION['email_answers'][$selectedEmail->getID()]);
        }
    } else {
        $selectedEmail = null;
    }

    if (isset($_POST['answer'])) {
        $selectedEmail = $emailsData->getEmail($_POST['selected']);
        $selectedEmail->setUserAnswer($_POST['answer']);
        $_SESSION['email_answers'][$selectedEmail->getID()] = $_POST['answer'];
    }

    $view->selectedEmail = $selectedEmail;
    $view->emails = $emailsData->getEmails();
    $view->emailCount = count($view->emails);
    $view->answerCount = count($_SESSION['email_answers']);

    foreach ($view->emails as $email) {
        if (isset($_SESSION['email_answers'][$email->getID()])) {
            $email->setUserAnswer($_SESSION['email_answers'][$email->getID()]);
        }
    }

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
}