<?php //1. Create a database connection
require("constants.php");
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
    printf("Failed to connect to MySQL: " . mysqli_connect_error());
    exit();
}