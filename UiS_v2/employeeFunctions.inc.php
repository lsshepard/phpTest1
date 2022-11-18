<?php

function getRoundNumber($conn) {
    $roundNumber;
    $row = mysqli_fetch_assoc($conn->query('SELECT roundNumber FROM program;'));
    $roundNumber = $row['roundNumber'];
    return($roundNumber);
}

function getQuestionsNr($conn) {
    $questionsNr;
    $row = mysqli_fetch_assoc($conn->query('SELECT questionsNr FROM program;'));
    $questionsNr = $row['questionsNr'];
    return($questionsNr);
}

function getQuestion($conn, $questionNr) {
    $question;
    $column = 'question' . $questionNr;
    $row = mysqli_fetch_assoc($conn->query('SELECT ' . $column . ' FROM program;'));
    $question = $row[$column];
    return($question);
}

function isEmployee($uid, $conn) {
    $result;
    $sqlEmployee = "SELECT * FROM employee WHERE employeeSetId  = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sqlEmployee)) {
        header("index.php?error=stmtfailed");
    }
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $result = $row;
    } else {
        $result = false;
    }

    return $result;
}       

function hasAnsweredAll($uid, $conn, $roundNumber) {
    $questionsNr = getQuestionsNr($conn);
    for ($i = 1; $i<=$questionsNr; $i+= 1) {
        $result = false;
        $column = 'question' . $i . 'answer' . $roundNumber;
        $sqlNotAnswered = 'SELECT ' . $column . ' FROM employee WHERE employeeSetId = ?;';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sqlNotAnswered)) {
            header("index.php?error=stmtfailed");
        }
        mysqli_stmt_bind_param($stmt, "i", $uid);
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        $answer = $row[$column];
        if ($answer !== NULL) {
            $result = true;
        }
        return($result);
    }
}

function hasAnsweredSingle($uid, $conn, $roundNumber, $questionsNr) {
    $result = false;
        $column = 'question' . $questionsNr . 'answer' . $roundNumber;
        $sqlNotAnswered = 'SELECT ' . $column . ' FROM employee WHERE employeeSetId = ?;';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sqlNotAnswered)) {
            header("index.php?error=stmtfailed");
        }
        mysqli_stmt_bind_param($stmt, "i", $uid);
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        $answer = $row[$column];
        if ($answer !== NULL) {
            $result = true;
        }
        return($result);
}

function submitAnswer($uid, $conn, $roundNumber, $answer, $questionNr) {
    if (hasAnsweredSingle($uid, $conn, $roundNumber, $questionNr)) {
        header("index.php?error=has answererd");
        echo "You have already submitted question " . $questionNr  . " this round.";
        exit();
    }

    else {
        $column = 'question' . $questionNr . 'answer' . $roundNumber;
        $sqlSubmitAnswer = 'UPDATE employee SET ' . $column .  '= ? WHERE employeeSetId = ?';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sqlSubmitAnswer)) {
            header("index.php?error=stmtfailed");
        }
        mysqli_stmt_bind_param($stmt, "ii", $answer, $uid);
        mysqli_stmt_execute($stmt);
    }
}