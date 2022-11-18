<?php
$uid = $_GET['uid'];
?>

<div class="questionText">
    <p>
        Question 2...
    </p>
</duv>

<div class="form">
    <form action='ratingSuccess.php' method='post'>
        <input type="hidden" name="uid" value=<?php echo $uid; ?>>
        <input type='range' min='1' max='5' name='rating' value='3' oninput="this.nextElementSibling.value = this.value">
        <output>3</output>
        <button type='submit' name='submit'>Submit</button>
    </form>
</div>