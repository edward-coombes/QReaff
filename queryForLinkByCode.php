<?php
function queryForLinkByCode($conn,$code){
	//echo "querying for link...\n";
	$fieldName = "directLink"; //for easy changing

	//form the query
	$query = "select " . $fieldName . " from QReaff.activeReaffs where chapterId = " . $code . ";";

	//execute it
	$result = mysqli_query($conn,$query);
	//echo $result->num_rows;
	//echo mysqli_error($conn);

	//grab the data
	$row = $result->fetch_assoc();
	//echo $row[$fieldName];

	//and return it
	$result->free();
 	return $row[$fieldName];
}

?>
