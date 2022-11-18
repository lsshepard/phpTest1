<?php
$uid = $_GET['uid'];
$question1 = getQuestion($conn, 1);
$question2 = getQuestion($conn, 2);
$question3 = getQuestion($conn, 3);
?>

<div class="questionText">
    <h3>
        Please answer the following questions:
    </h3>
</div>

<div class="form">
    <form action='ratingSuccess.php' method='post'>
        <input type="hidden" name="uid" value=<?php echo $uid; ?>>
        <div class="input">
            <p>
                <?php echo $question1; ?>
            </p>
            <input type='number' min='1' max='5' name='rating1' value='3'>
        </div>
        <div class="input">
            <p>
            <?php echo $question2; ?>
            </p>
            <input type='number' min='1' max='5' name='rating2' value='3'>
        </div>
        <div class="input">
            <p>
            <?php echo $question3; ?>
            </p>
            <input type='number' min='1' max='5' name='rating3' value='3'>
        </div>
        <button type='submit' name='submit'>Submit</button>
    </form>
</div>