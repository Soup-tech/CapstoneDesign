<?php

$servername = "localhost";
$dbuname = "root";
$dbpass = "G0dH@d3s";
$dbname = "capstone";

$conn = mysqli_connect($servername,$dbuname,$dbpass,$dbname);

if (!$conn) {
	echo "Failed to connect to MYSQL: ". mysqli_connect_error();
}
