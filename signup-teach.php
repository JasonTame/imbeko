<?php

    //Initialize variables
    $from = "info@imbeko.org";
    $sendTo = "admin@imbeko.org";
    $subject = "Imbeko Tutor Signup Form Submission";
    $fields = array('name' => 'Name', 'email' => 'Email', 'number' => 'Number',  'language' => 'Language', 'addressInput' => 'Address', 'day-option1' => 'Day Option 1',
     'time-option1' => 'Time Option 1', 'day-option2' => 'Day Option 2', 'time-option2' => 'Time Option 2',
    'day-option3' => 'Day Option 3', 'time-option3' => 'time-option3', 'day-option4' => 'Day Option 4',
    'time-option4' => 'Time Option 4', 'find-out' => 'Where did you found out about Imbeko?',
    'extra-details' => 'Extra Details');
    $okMessage = 'Signup form successfully submitted. Thank you, someone from our staff will be in touch soon!';
    $errorMessage = 'There  was an error while submitting the form. Please try again later';

    error_reporting(E_ALL & ~E_NOTICE);


    try {
        if(count($_POST) == 0) throw new \Exception('Form is empty');

        foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }

        // All the neccessary headers for the email.
        $headers = array('Content-Type: text/plain; charset="UTF-8";',
            'From: ' . $from,
            'Reply-To: ' . $from,
            'Return-Path: ' . $from,
        );

    }
        mail($sendTo, $subject, $emailText, implode("\n", $headers));

        $responseArray = array('type' => 'success', 'message' => $okMessage);

    } catch (\Exception $e ) {
        $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    }

    // if requested by AJAX request return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $encoded = json_encode($responseArray);

        header('Content-Type: application/json');

        echo $encoded;
    }
    // else just display the message
    else {
        echo $responseArray['message'];
    }







?>
