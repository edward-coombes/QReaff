<?php
function initConnection(){
	//echo "initializing database connection...\n";
    //create the connection to the server

    //this will be fine as long as the database is held on the same server as this file.
    $servername = "localhost";
    $username = "QReaff";
    $password = "\$uperL337";

    $conn = new mysqli($servername,$username,$password);

    if ($conn->connect_error){
        die("connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
