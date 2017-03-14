<?php
$servername = "localhost";
$password;
$username;
$databasename= "forum";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$databasename");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // will be removed at release
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>
