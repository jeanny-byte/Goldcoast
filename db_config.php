<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'goldcoast_user');
define('DB_PASSWORD', 'goldco@st');
define('DB_NAME', 'goldcoast');

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?> 