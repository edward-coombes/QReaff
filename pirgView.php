<?php
require "initConnection.php";
function generateSelectTag(){
    $conn = initConnection();
    $query = "select id, name from QReaff.chapters";
    $result = $conn->query($query);

    echo "<select id=\"chapterSelect\" name=\"chapterSelect\">\n";
    $i = 0;
    while($row = $result->fetch_assoc()){
        echo "<option ";
        echo "value = \" " . $row["id"]  . " \">";
        echo $row["name"];
        echo "</option>\n";
        i++;
    }
    echo "\n</select>";
    echo "<p id=\"selectMax\" hidden>".$i."</p>";
}
?>

<html>
    <head>
        QReaff System
    </head>
<body>
    <div id="header">
        QReaff
    </div>

    <div id="mainContainer">
        <form id="theForm" action="updateReaff.php" method="POST" >
            <label> Chapter: </label>
            <?php generateSelectTag()?>

            <label> Reaff Vote Link: </label>
            <input type="text" name="link" id="reaffLink" value="https://votingWebsite.org/yourSchoolSpecifically">

            <label> Reaff Start Date: </label>
            <input type="date" name="startDate" id="startDate" >

            <label> Reaff End Date: </label>
            <input type="date" name="endDate" id="endDate" >

            <input type="button" id="submit" value="submit">
        </form>
    </div>

    <script>
     function formIsValid(){
         //check the link
         linkExpr = new RegExp('((http[s]?):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#\s]+)(.*)?(#[\w\-]+)?$');
         //make sure that there is a link with valid format
         reafLink = document.getElementById("reaffLink");
         if (!reafLink.value.match(linkExpr)){
             highlight(reafLink);
             return false;
         }

         //check the chapter
         chapter = document.getElementById("chapterSelect");
         chapterMax = document.getElementById("selectMax");
         if(!chapter.value){
             highlight("chapter");
             return false;
         }
         if(chapter.value < 0 || chapter.value > chapterMax.innerHTML){
             highlight(chapter);
             return false;
             }

         //check the datesi
         s = document.getElementById("startDate");
         e = document.getElementById("endDate");
         startD = new Date(s.value);
         endD = new Date(e.value);
         today = new Date();

         if (startD >= endD || today >= endD){
             highlight(s);
             highlight(e);
             return false;
         }

         //if it gets this far, then everything is gucci
         return true;
     }

function highlight(e){
    //give it a red border, which changes to black when it is clicked on
    e.style.borderColor = "red";
    e.addEventListener("click",function(){
        this.style.borderColor="black";
        this.removeEventListener("click");});
}

     if(formIsValid())
         document.getElementById("theForm").submit();
    </script>

</body>
</html>
