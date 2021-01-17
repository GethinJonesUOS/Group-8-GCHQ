<?php

require_once 'Models/Users.php';
require_once 'Models/Emails.php';
require_once 'Models/HintGenerator.php';
require_once 'Models/Tooltips.php';
require_once 'Models/Tests.php';

if (!isLoggedIn()) {
    //header('location: /index.php');
    //exit;
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'scoreslist':
            header('Content-Type: application/json');
            echo json_encode($_SESSION['email_answers']);
            break;
        case 'useranswer':
            header('Content-Type: application/json');
            if (isset($_SESSION['email_answers']) && isset($_SESSION['email_answers'][$_POST['id']])) {
                $answer = $_SESSION['email_answers'][$_POST['id']];
            } else {
                $answer = "null";
            }
            echo "{
                \"answer\": \"$answer\"
            }";
            break;
        default:
            echo 'error';
    }
} else if (isset($_POST['submit'])) {
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
} else if (isset($_POST['selected'])) {
    $selected = $_POST['selected'];
    $emailsData = new Emails();
    $selectedEmail = $emailsData->getEmail($selected);

    header('Content-Type: application/json');
    $subject = $selectedEmail->getSubject();
    $from = $selectedEmail->getFrom();
    $fromName = $selectedEmail->getFromName();
    echo "{
        \"from\": \"$from\",
        \"fromName\": \"$fromName\",
        \"subject\": \"$subject\"
    }";
} else if (isset($_GET['emailbody'])) {
    $selected = $_GET['emailbody'];
    $emailsData = new Emails();
    $usersData = new Users();

    $selectedEmail = $emailsData->getEmail($selected);
    $user = $usersData->getUserInfo($_SESSION['user_id'])[0];

    $hintGenerator = new HintGenerator(str_replace('<<forename>>', $user->getFirstName(), $selectedEmail->getBody()));
    $tooltips = new Tooltips();
    $toolTipsData = $tooltips->getTooltips();

    foreach ($toolTipsData as $tooltip) {
        $hintGenerator->addTooltip($tooltip->getId(), $tooltip->getText());
    }

    $toolTipsData = $tooltips->getTooltips();

    echo $hintGenerator->transform();
} else if (isset($_POST['answeremail'])) {
    $_SESSION['email_answers'][$_POST['answeremail']] = $_POST['answer'];

    $emailsData = new Emails();
    $emails = $emailsData->getEmails();
    $emailCount = count($emails);
    $answerCount = count($_SESSION['email_answers']);

    header('Content-Type: application/json');
    echo "{
        \"emailCount\": \"$emailCount\",
        \"answerCount\": \"$answerCount\"
    }";
} else if (isset($_POST['reset'])) {
    if ($_POST['reset'] == 'true') {
        $_SESSION['email_answers'] = [];
    }
} else {
    if (!isset($_SESSION['email_answers'])) {
        $_SESSION['email_answers'] = [];
    }

    $view = new stdClass();
    $view->pageTitle = 'Email';
    $view->scripts = ['/js/email.js'];

    $emailsData = new Emails();
    $view->emails = $emailsData->getEmails();

    include_once('Views/email.phtml');
}