<?php

/* Database connection start */
$servername = "localhost";
$username = "fixwei_pageroot";
$password = "l_9&e~Lu+SzX";
$dbname = "fixwei_c9rp5r4t2v8";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>