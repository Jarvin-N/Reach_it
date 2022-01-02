<?php
/*
DATABASE PHP
Imesh Nimsitha
ICS4UR-A Mr. Brown
*/

include "core.php";

// Establish new SQL connection variable
function db() {
    static $conn;

    // MySQL login information
    $servername = "remotemysql.com";
    $username = "N6S9LBHaGk";
    $password = "L1J4ZvU2Gi";
    $dbname = "N6S9LBHaGk";

    if ($conn === NULL){
        $conn = new mysqli($servername, $username, $password, $dbname);
    }

    // If unable to connect
        if($conn->connect_error){
            die("Could not connect to database: " . $conn->connect_error);
        }
    // Connection is successful!
        clog("Connected to database.");

    return $conn;
}
