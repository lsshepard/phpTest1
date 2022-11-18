<?php

function isLeader($uid, $conn) {
    $result;
    $sqlLeader = "SELECT * FROM leader WHERE leaderSetId  = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sqlLeader)) {
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

function averageAnswer($uid, $conn, $roundNumber, $questionNr) {
    $column = 'question' . $questionNr . 'answer' . $roundNumber;
    $row = mysqli_fetch_assoc($conn->query('SELECT AVG(' . $column . ') AS avg_answer FROM employee WHERE leaderSetId=' . $uid . ';'));
    $avgAnswer = $row['avg_answer'];
    return($avgAnswer);
}

function graphAverages($uid, $conn, $roundNumber, $questionNr) {
    $data = array();
    for ($i = 1; $i <= $roundNumber; $i+=1) {
        $avg = averageAnswer($uid, $conn, $i, $questionNr);
        array_push($data, $avg);
        //echo $avg;
    }

    $js_data = json_encode($data);
    $canvas_id = 'canvas' . $questionNr;
    $question = getQuestion($conn, $questionNr);

    echo "
        <canvas id='$canvas_id' width='640' height='400'></canvas>
        <script type='text/Javascript'>
            var data = $js_data;
        </script>
    ";
    echo "
        <h3>$question</h3>
        <script type='text/Javascript'>
        canvas = document.getElementById('$canvas_id');
        console.log(canvas);
        ctx = canvas.getContext('2d');
        columnDataHeigth = canvasHEIGHT*2/15;
        columnSpace = Math.floor(canvasWIDTH/(data.length+1));
        green = 150/data.length;
        for(let i = 0; i <= data.length; i ++) {
            ctx.fillStyle = 'rgb(0, ' + (250-(green*(i+1)))+', 0)';
            ctx.beginPath();
            ctx.moveTo((columnSpace*(i+1))+columnWidth, canvasHEIGHT);
            ctx.lineTo((columnSpace*(i+1))-columnWidth, canvasHEIGHT);
            ctx.lineTo((columnSpace*(i+1))-columnWidth, canvasHEIGHT-(columnDataHeigth*data[i]));
            ctx.lineTo((columnSpace*(i+1))+columnWidth, canvasHEIGHT-(columnDataHeigth*data[i]));
            ctx.lineTo((columnSpace*(i+1))+columnWidth, canvasHEIGHT);
            ctx.fill();
        }
    </script>
    ";
    
}

function graphAllAverages($uid, $conn, $roundNumber, $questionsNr) {
    echo "
    <script type='text/Javascript'>
        const canvasWIDTH = 640;
        const canvasHEIGHT = 400;
        const columnWidth = 30;
        let ctx;
        let columnDataHeigth;
        let columnSpace;
        let green;
        let canvas;
    </script>
    ";
    for ($i = 1; $i <= $questionsNr; $i += 1) {
        graphAverages($uid, $conn, $roundNumber, $i);
    }
}