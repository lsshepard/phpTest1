<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index.css">
    <title>Spørreundersøkelse</title>
</head>
<body>
    <div class="box">
        <?php
            if (isset($_GET['uid'])) {
                
                require_once('dbh.inc.php');
                require_once('employeeFunctions.inc.php');
                require_once('leaderFunctions.inc.php');
                $uid = $_GET['uid'];
                $roundNumber = getRoundNumber($conn);
                $questionsNr = getQuestionsNr($conn);

                if (isEmployee($uid, $conn) !== false) {

                    if(!hasAnsweredAll($uid, $conn, $roundNumber)) {
                        require_once('ratingForm.inc.php');
                    }

                    else {
                        echo 'You have already submitted an answer this round.';
                    }
                }


                else if (isLeader($uid, $conn)) {
                    //averageAnswer($uid, $conn, $roundNumber);
                    graphAllAverages($uid, $conn, $roundNumber, $questionsNr);
                    // if (leaderAnswersExist($uid)) {
                    //     //php graph answers
                    // }

                //     else {
                //         //php answers not availible yet
                //     }
                }
            }
        ?>
    </div>
</body>
</html>