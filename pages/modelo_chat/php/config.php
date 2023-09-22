<?php
$hostname = 'localhost';
$username = 'fixwei_pageroot';
$password = 'l_9&e~Lu+SzX';
$dbname = "fixwei_c9rp5r4t2v8";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
  echo "Error con la conexión de base de datos " . mysqli_connect_error();
}
