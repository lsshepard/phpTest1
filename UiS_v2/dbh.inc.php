<?php

$serverName = "";
$dBUsername = "";
$dBPassword = "";
$dBName = "";  

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
