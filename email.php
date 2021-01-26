<?php

require_once 'Models/Users.php';
require_once 'Models/Emails.php';
require_once 'Models/HintGenerator.php';
require_once 'Models/Tooltips.php';
require_once 'Models/Tests.php';

// Redirect to login page if request is received without logged in session
if (!isLoggedIn()) {
    header('location: /login.php');
    exit;
}

// POST request with action parameter
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'scoreslist': // Get a list of answers provided for each question
            header('Content-Type: application/json');
            echo json_encode($_SESSION['email_answers']);
            break;
        case 'useranswer': // Get the user's answer for a specific email
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
        case 'getheader': // Get the email header
            $selected = $_POST['id'];
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
            break;
        case 'answeremail': // Provide an answer for a uestion
            $_SESSION['email_answers'][$_POST['id']] = $_POST['answer'];

            $emailsData = new Emails();
            $emails = $emailsData->getEmails();
            $emailCount = count($emails);
            $answerCount = count($_SESSION['email_answers']);

            header('Content-Type: application/json');
            echo "{
                    \"emailCount\": \"$emailCount\",
                    \"answerCount\": \"$answerCount\"
                }";
            break;
        case 'reset': // Reset the user's answers
            $_SESSION['email_answers'] = [];
            break;
        default:
            echo 'error';
    }
    // Submit score to the database and redirect to the profile page.
    // TODO: Should be a post action.
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
            $tests->addResults($result);
            header('location: /profile.php');
            exit;
        } else {
            echo 'An unexpected error has occured.';
            exit;
        }
    }
    // Get the contents of an email bdy from the database
    //TODO: Should be a GET action.
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
    // If no parameters are provided, return the view
} else {
    if (!isset($_SESSION['email_answers'])) {
        $_SESSION['email_answers'] = [];
    }

    $view = new stdClass();
    $view->pageTitle = 'Email';

    // Push email.js file into the view footer
    $view->scripts = ['/js/email.js'];

    $emailsData = new Emails();
    $view->emails = $emailsData->getEmails();

    include_once('Views/email.phtml');
}