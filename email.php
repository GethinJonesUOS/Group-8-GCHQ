<?php


require_once 'Models/Users.php';
require_once 'Models/Emails.php';
require_once 'Models/HintGenerator.php';
require_once 'Models/Tooltips.php';

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

            echo "Score: $score" . PHP_EOL;
        } else {
            echo 'An unexpected error has occured.';
            exit;
        }
    }
} else {

    $view = new stdClass();
    $view->pageTitle = 'Email';

    if (isset($_POST['reset']) && $_POST['reset'] == 'true') {
        unset($_SESSION['email_answers']);
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