<?php
require "initConnection.php";
require "queryForLinkByCode.php";

function getClosestSchool($conn,$lat,$lon){
	$query = "select id,latitude,longitude from QReaff.chapters;";

	$result = $conn->query($query);

	$distanceTolerance = 5;	

	$potentialChapters = array();
	$distances = array();

	//check the distance to each result
	while($row = $result->fetc_assoc()){
		$d = distance($lat,$lon,$row["latitude"],$row["longitude"],"M");
		if ($d <= $distanceTolerance){
			//this is probably the right chapter
			$potentialChapters.push($row);
			$distances.push($d);
		}
	}
	$result->free();
	if (count($potentialChapters) == 0 ){
		//no chapter found within 5 miles
		return -1;
	} else if (count($potentialChapters) == 1) {
		return $potentialChapters[0]["id"];
	} else {
		$chapterI = 0;
		//this loop gets the index of the closest chapter
		for($i = 0; $i < count($potentialChapters);i++){
			$chapterI = ($distances[i] < $distances[chapterI])?i:chapterI; 
		}
		return $potentialChapters[chapterI]["id"];
	}
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                         :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                       :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2017   		     :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

if (array_key_exists("lat",$_POST) && array_key_exists("lon",$_POST)){
	$lat = filter_var($_POST["lat"],FILTER_SANITIZE_NUMBER_FLOAT);
	$lon = filter_var($_POST["lon"],FILTER_SANITIZE_NUMBER_FLOAT);

	$conn = initConnection();
	$closestSchool = getClosestSchool($conn,$lat,$lon);
	if ($closestSchool == -1){
		echo "inconclusive";
	} else {
		echo queryForLinkByCode($closestSchool);
	}
}
?>
