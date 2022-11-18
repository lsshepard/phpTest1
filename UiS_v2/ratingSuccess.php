<?php

require_once('employeeFunctions.inc.php');
require_once('dbh.inc.php');

if (isset($_POST['submit'])) {

    $uid = $_POST['uid'];
    $roundNumber = getRoundNumber($conn);
    $questionsNr = getQuestionsNr($conn);


    for ($i = 1; $i <= $questionsNr; $i+= 1) {
        $answer = $_POST['rating' . $i];
        submitAnswer($uid, $conn, $roundNumber, $answer, $i);
        echo 'Answer ' . $answer . ' successfully submitted. ';
    }


} else {
    echo "no submit";
    header("index.php?error=norating");
}