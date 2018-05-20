<?php
require "initConnection.php";
/*
  accepting post arguments "link" "startDate" and "endDate"
*/

function insertData(){
    //initialize connection
    $conn = initConnection();

    if ($conn->connect_errno){
        echo "\nConnection failed...";
        exit(); //if the connection fails, let the user know & quit
    }

    //This is the query string that will be executed
    $queryStr = "UPDATE QReaff.activeReaffs SET directLink = '" . $_POST["link"]
           . "', startDate = '" . $_POST["startDate"]
           . "', endDate = '" . $_POST["endDate"]
           . "' WHERE chapterId = " . $chID . ";";


    if($conn->query($queryStr) === TRUE){
        echo "\nReaff successfully updated";
    } else {
        echo "\nSomething went wrong while updating your Reaff information";
    }

}

//This block of code validates / sanitizes all of the data before it gets in the db
if( array_key_exists("link",$_POST) &&
    array_key_exits("id",$_POST) &&
    array_key_exists("startDate",$_POST) &&
    array_key_exists("endDate",$_POST)){

    $allGood = true;
    $idProb = false;
    $linkProb = false;
    $dateProb = false;

    if(!filter_var($_POST["link"],FILTER_VALIDATE_URL)){
        $allGood = false;
        $linkProb = true;
    }
    if(!filter_var($_POST["id"],FILTER_VALIDATE_INT)){
        $allGood = false;
        $idProb = true;
    }

    $dateStrs = ["startDate","endDate"];
    foreach($dateStrs as $d){
        $checkArr = explode("/",$_POST[$d]);
        if(count($checkArr) == 3){
            if(!checkdate($checkArr[0],$checkArr[1],$checkArr[2])){
                $allGood = false;
                $dateProb = true;
            }
        }
    }
}

if($allGood){
    insertData();
} else {
    if($dateProb)
        echo "Your dates are messed up\n";
    if($linkProb)
        echo "Your link is messed up\n";
    if($idProb)
        echo "Your chapter ID is messed up\n";
}
?>
