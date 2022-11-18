<?php

$serverName = "kczasktwxv";
$dBUsername = "kczasktwxv";
$dBPassword = "T4r4smWxq9";
$dBName = "uis1";  

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
