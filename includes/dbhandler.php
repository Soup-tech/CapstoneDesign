<?php

$servername = "localhost";
$dbuname = "root";
$dbpass = "";
$dbname = "capstone";

$conn = mysqli_connect($servername,$dbuname,$dbpass,$dbname);

if (!$conn) {
	echo "Failed to connect to MYSQL: ". mysqli_connect_error();
}
