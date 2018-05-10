<html>
<body>
<p id="GeoLocOut"> starting... </p>
<?php
     require "initConnection.php";
     require "queryForLinkByCode.php";

function keyIsGeneric($k){
	if($k==0){
		//im enviaioning using this to catch a code which msy be printed on a generic state wide / shared forum/flier
		return true;
	}
	return false;
}

$geoTag = "<script src=\"geoLocationRoutine.js\"></script>";

if(array_key_exists("chapterId",$_GET) ){
	//echo "chapter Id found\n";
	//never trust your users
	$getCondom = $_GET["chapterId"];

  	//if there is a key supplied
	if(keyIsGeneric($getCondom)){
		echo $geoTag;
	} else {

		$conn = initConnection();
		$link = queryForLinkByCode($conn, $getCondom);
		echo $link;
		echo "<script> window.location.replace(\"" .$link. "\");</script>";
		mysqli_close($conn);
	}
} else {
	echo "No Chapter Id specified\n";
	echo $geoTag;
}
?>
</body>
</html>
