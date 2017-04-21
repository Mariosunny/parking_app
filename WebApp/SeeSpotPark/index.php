<?php
$db = new SQLite3('../db.sqlite3') or die("nope!");

$results = $db->query('SELECT * FROM main_app_enclosedparkinglot');
$n = 0;
$ratio = 0;
while ($row = $results->fetchArray()) {
	$ratio = intval(($row[4] / $row[3])*100);
	$rows[$n]=$row;
	$ratios[$n]=$ratio;
	$n++;
}
$db->close();
//	For now, the number of open spots are determined with random numbers.
// The code below determines if the modified pin for parking lot f is red or blue.
if($ratios[0]==100){
	$bgColor = "https://seespotpark.site/images/marker_background_red.png";
}else if($ratios[0]>89 && $ratios[0]<=99){
	$bgColor = "https://seespotpark.site/images/marker_background_yellow.png";
}else if($ratios[0]<=89){
	$bgColor = "https://seespotpark.site/images/marker_background.png";
}
// The code below determines the text for parking lot f AND the text for "responsivevoice.js" .
	$alert = $ratios[0] . "% Full";
	$script = "Parking lot, F is " . $alert;

// The code below determines if the modified pin for parking lot 7f is red or blue.
if($ratios[1]==100){
	$bgColor2 = "https://seespotpark.site/images/lot_7_red.png";
}else if($ratios[1]>89 && $ratios[1]<=99){
	$bgColor2 = "https://seespotpark.site/images/lot_7_yellow.png";
}else if($ratios[1]<=89){
	$bgColor2 = "https://seespotpark.site/images/lot_7.png";
}
// The code below determines the text for parking lot 7 AND the text for "responsivevoice.js" .

	$alert2 = $ratios[1] . "% Full";
	$script2 = "Parking lot, 7 is " . $alert2;
	
if($ratios[2]==100){
	$bgColor3 = "https://seespotpark.site/images/parking_lot_d_red.png";
}else if($ratios[2]>89 && $ratios[2]<=99){
	$bgColor3 = "https://seespotpark.site/images/parking_lot_d_yellow.png";
}else if($ratios[2]<=89){
	$bgColor3 = "https://seespotpark.site/images/parking_lot_d.png";
}
	$alert3 = $ratios[2] . "% Full";
	$script3 = "Parking lot D is " . $alert3 ;

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Welcome to See Spot Park - TAMUK's campus parking tracking system." />
<link rel="stylesheet" type="text/css" media="all" href="css/style.css?ts=<?=time()?>" />
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
<script src='js/call.js'></script><!-- this is for the voice output -->
<script src='js/responsivevoice.js'></script><!-- this is for the voice output -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<title>See.Spot.Park.</title>
</head>
<body>

<!-- below is the see spot park logo -->
<header class="header" >
</header>
<input type="hidden" id="hidden0" value="<?php echo $ratios[0]; ?>" />
<input type="hidden" id="hidden1" value="<?php echo $ratios[1]; ?>" />
<input type="hidden" id="hidden2" value="<?php echo $ratios[2]; ?>" />
<!-- below is the text seen on screen -->
<div style="color:black;" >Press the green button and say: "<strong>Find me a spot</strong>", and we'll fetch the spot closest to you!</br>
Click a blue (<img src="images/mini.png" style="width:24px;" />) or red (<img src="images/mini_red.png" style="width:24px;" />) highlighted area and we'll tell you how many spots are available in that lot.</div>
<!-- below is the html <div> for the google map. -->
<div class="main_body" >

<input type="button" name="button" class="button_click" value="press to find a spot" onclick="button_click()" /></br></br>
	<div id="map"></div>
</div>
<!-- below is a <div> for printing out the users lat. and long.  It is hidden for now. -->
<div style="color:black;display:none;" id="demo">hello</div>
<!-- below is the javascript that actually prints the map -->
 <script>
// first get the "demo" <div> element and place it into the "x" variable
	  var x = document.getElementById('demo');
// then get the users location by calling "getLocation()"
	var ret = getLocation();
// declare an array to hold users lat. and long.
	var y=new Array();
// below is the "getLocation()" function for getting the user's location.
	function getLocation() {
		if (navigator.geolocation) {
			// if the location is gathered, that information is sent to the "showPosition()" function
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			// if not, this is printed instead
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}
// below, the "showPosition() function is defined.  It accepts the position gathered above as an argument"
var y;
	function showPosition(position) {
		// The onscreen text is changed to this string.  Again, though, it is hidden for now.
		x.innerHTML = "{lat: " + position.coords.latitude + 
		", lng: " + position.coords.longitude + "}"; 
		// more importantly, the user's lat. and long. are set into the array.
		y[0]=position.coords.latitude; 
		y[1]=position.coords.longitude; 
	}
	  // Below, the map is actually rendered
      function initMap() {
		  navigator.geolocation.getCurrentPosition(go);
		// For now, the lat. and long. of the two parking lots are hard-coded.  They need to come from a database.
		function go(position){
		var a = position.coords.latitude;
		var b = position.coords.longitude;
		var user_latLng = new google.maps.LatLng(a, b);
        var Parking_Lot_F = {lat: 27.526794, lng: -97.878555};
		var Parking_Lot_7 = {lat: 27.525230, lng: -97.878214};
		var Parking_Lot_d = {lat: 27.527342, lng: -97.882922};
		/* below, assign the PHP values of "$alert" and "$alert2" into the javascript variables label and label2
		respectively */
		var label = '<?php print $alert; ?>';
		var label2 = '<?php print $alert2; ?>';
		var label3 = '<?php print $alert3; ?>';
		// below, a new map object is declared
        window.map = new google.maps.Map(document.getElementById('map'), {
		  // the attributes of the map are set
          zoom: 19, // this is , obviously, the zoom level
		  zoomControl: false, // This removes the zoom control
          center: user_latLng // this sets the center at parking lot f, this needs to be set dynamically
        });
		// more setting PHP into javascript
		var icon = "<?php echo $bgColor; ?>";
		// below, a new marker object is created for parking lot f
        var marker = new google.maps.Marker({
		  // again, we can set the attributes we wish to change
          position: Parking_Lot_F,
          label:  {
			  text: label,
			  color: 'white'
			  },
		  icon: icon,
		  // the attribute below places this marker on our map
		  map: map
        });
		// same as above, but for parking lot f
		var icon2 = "<?php echo $bgColor2; ?>";
		var marker2 = new google.maps.Marker({
          position: Parking_Lot_7,
          label: {
			  text: label2,
			  color: 'white'
			  },
		  icon: icon2,
		  map: map
        });
		var icon3 = "<?php echo $bgColor3; ?>";
		var marker3 = new google.maps.Marker({
          position: Parking_Lot_d,
          label: {
			  text: label3,
			  color: 'white'
			  },
		  icon: icon3,
		  map: map
        });
		var user_marker = new google.maps.Marker({
          position: user_latLng,
          label: {
			  text: 'You Are Here',
			  color: 'white'
			  },
		  map: map
        });
		// a variable is declared to hold the position of the center of the map
		var center;
		// below, the "calculateCenter()" function is defined
		//function calculateCenter() {
			// Again, this is hard-coded, but needs to be dynamic
		  //center = Parking_Lot_F;
		//}
		// the event listeners below listen for click actions on the markers (pins)
		google.maps.event.addDomListener(marker, 'click', function() {
		  // they cause the voice output to give the number of open spots in that lot, in particular.
		  responsiveVoice.speak("<?php print $script; ?>","US English Female");
		});
		google.maps.event.addDomListener(marker2, 'click', function() {
		  responsiveVoice.speak("<?php print $script2; ?>","US English Female");
		});
		google.maps.event.addDomListener(marker3, 'click', function() {
		  responsiveVoice.speak("<?php print $script3; ?>","US English Female");
		});
		/* the functions below are meant to calculate the center of the map on idle, and 
		recenter the map on window resize 
		google.maps.event.addDomListener(map, 'idle', function() {
		  calculateCenter();
		});
		google.maps.event.addDomListener(window, 'resize', function() {
		  map.setCenter(center);
		});*/
		}
      }
	  function button_click(){
		  var Parking_Lot_F = {lat: 27.526794, lng: -97.878555};
		var Parking_Lot_7 = {lat: 27.525230, lng: -97.878214};
		var Parking_Lot_d = {lat: 27.527342, lng: -97.882922};
		var lot_f_lat = 27.526794 - parseFloat(y[0]);
		var lot_f_long = 97.878555 - parseFloat(y[1]);
		var dist1 = Math.sqrt((lot_f_lat * lot_f_lat)+(lot_f_long * lot_f_long));
		var lot_7_lat = 27.525230 - parseFloat(y[0]);
		var lot_7_long = 97.878214 - parseFloat(y[1]);
		var dist2 = Math.sqrt((lot_7_lat * lot_7_lat)+(lot_7_long * lot_7_long));
		var lot_d_lat = 27.527342 - parseFloat(y[0]);
		var lot_d_long = 97.882922 - parseFloat(y[1]);
		var dist3 = Math.sqrt((lot_d_lat * lot_d_lat)+(lot_d_long * lot_d_long));
		var audio = new Audio('woof.mp3');
		var rat0 = document.getElementById("hidden0").value;
		var rat1 = document.getElementById("hidden1").value;
		var rat2 = document.getElementById("hidden2").value;
		// The code below is SUPPOSED to relay the nearest lot of the two via audio output
		if(rat0 == 100){
			if(rat1 == 100){
				if(rat2 == 100){
					audio.play();
					setTimeout(function(){ responsiveVoice.speak("There is no open parking","US English Female"); }, 1000);
				}else{
					audio.play();
					setTimeout(function(){ responsiveVoice.speak("<?php print $script3; ?>","US English Female"); }, 1000);
					map.setCenter(Parking_Lot_d);					
				}
			}else{ 
				if(rat2 == 100){
					audio.play();
					setTimeout(function(){ responsiveVoice.speak("<?php print $script2; ?>","US English Female"); }, 1000);
					map.setCenter(Parking_Lot_7);
				}else{
					if(dist2 < dist3){
						audio.play();
						setTimeout(function(){ responsiveVoice.speak("<?php print $script2; ?>","US English Female"); }, 1000);	
						map.setCenter(Parking_Lot_7);
					}else{
						audio.play();
						setTimeout(function(){ responsiveVoice.speak("<?php print $script3; ?>","US English Female"); }, 1000);	
						map.setCenter(Parking_Lot_d);
					}
				}
			}
		}else{ 
			if(rat1 == 100){
				if(rat2 == 100){
					audio.play();
					setTimeout(function(){ responsiveVoice.speak("<?php print $script; ?>","US English Female"); }, 1000);
					map.setCenter(Parking_Lot_F);
				}else{
					if(dist1 < dist3){
						audio.play();
						setTimeout(function(){ responsiveVoice.speak("<?php print $script; ?>","US English Female"); }, 1000);
						map.setCenter(Parking_Lot_F);						
					}else{
						audio.play();
						setTimeout(function(){ responsiveVoice.speak("<?php print $script3; ?>","US English Female"); }, 1000);
						map.setCenter(PParking_Lot_d);
					}
				}
			}else{
				if(rat2 == 100){
					if(dist1 < dist2){
						audio.play();
						setTimeout(function(){ responsiveVoice.speak("<?php print $script; ?>","US English Female"); }, 1000);	
						map.setCenter(Parking_Lot_F);
					}else{
						audio.play();
						setTimeout(function(){ responsiveVoice.speak("<?php print $script2; ?>","US English Female"); }, 1000);
						map.setCenter(Parking_Lot_7);
					}
				}else{
					if(dist1 < dist2){
						if(dist1 < dist3){
							audio.play();
							setTimeout(function(){ responsiveVoice.speak("<?php print $script; ?>","US English Female"); }, 1000);	
							map.setCenter(Parking_Lot_F);
						}else{
							audio.play();
							setTimeout(function(){ responsiveVoice.speak("<?php print $script3; ?>","US English Female"); }, 1000);	
							map.setCenter(PParking_Lot_d);
						}
					}else {
						if(dist2 < dist3){
							audio.play();
							setTimeout(function(){ responsiveVoice.speak("<?php print $script2; ?>","US English Female"); }, 1000);	
							map.setCenter(Parking_Lot_7);
						}else{
							audio.play();
							setTimeout(function(){ responsiveVoice.speak("<?php print $script3; ?>","US English Female"); }, 1000);	
							map.setCenter(PParking_Lot_d);
						}
					}
				}
			}
		}
	}
 </script>
 <!-- the script below is for accessing the google maps API -->
	 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6zNJLvNxe39Wy3Kcd8wX2mJD31aPOJdQ&callback=initMap">
    </script>
<div id="id01" style="color:black;" ><?php
for($i=0;$i<count($rows);$i++){
	echo "Parking lot #" . $rows[$i][0] . ":   Available-" . $rows[$i][3] . "   Filled-" . $rows[$i][4] . "</br>";
}
?>
</div>
	
</body>
<hr><!--  visible pagebreak  
<!-- below is the footer -->
<footer class="footer" >
		&copy; See Spot Park | 2017
</footer>
</html>
<!-- EOF -->