
function geoSuccess(position){
	//get the latitude and longitude
	lat = position.coords.latitude;
	lon = position.coords.longitude;
	//prepare them for transport
	params = "lat="+lat+"&lon="+lon;

	http = new XMLHttpRequest(); //create the request object

	url = "geoLoc.php";
	http.open('POST',url,true);
	http.setRequestHeader("Content-type","application/x-www-form-urlencoded");

	http.onreadystatechange = function () {
		if (this.readyState == 4) {
			if (this.responseText == "inconclusive")
				geoError();
			else {
				window.location.replace(this.responseText);
			}
		}
	}
	http.send(params);
}

function geoError(){
	outTag = document.getElementById("GeoLocOut");
	outTag.innerHTML = "Cannot find your current position.";
}

var geoOptions = {
	enableHighAccuracy 	: true,
	maximumAge		: 30000,
	timeout			: 27000
};


function main(){
	//this is where we will print out anything that the user needs to know.
	outTag = document.getElementById("GeoLocOut");

	if("geolocation" in navigator){
		  navigator.geolocation.getCurrentPosition(geoSuccess,geoError,geoOptions);
  } else {
		  outTag.innerHTML = "Please enable locaton services";
	}
}
main();
