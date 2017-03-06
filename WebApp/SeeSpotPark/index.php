<?php
//	For now, the number of open spots are determined with random numbers.
$num = rand(0,10);
$num2 = rand(0,10);
// The code below determines if the modified pin for parking lot f is red or blue.
if($num==0){
	$bgColor = "https://thomaswurdinger.com/SeeSpotPark/images/marker_background_red.png";
}else{
	$bgColor = "https://thomaswurdinger.com/SeeSpotPark/images/marker_background.png";
}
// The code below determines the text for parking lot f AND the text for "responsivevoice.js" .
if($num==1){
	$alert = $num . " spot open!";
	$script = "There is " . $alert . " in parking lot, F";
}else{
	$alert = $num . " spots open!";
	$script = "There are " . $alert . " in parking lot, F";
// The code below determines if the modified pin for parking lot 7f is red or blue.
}if($num2==0){
	$bgColor2 = "https://thomaswurdinger.com/SeeSpotPark/images/lot_7_red.png";
}else{
	$bgColor2 = "https://thomaswurdinger.com/SeeSpotPark/images/lot_7.png";
}
// The code below determines the text for parking lot 7 AND the text for "responsivevoice.js" .
if($num2==1){
	$alert2 = $num2 . " spot open!";
	$script2 = "There is " . $alert2 . " in parking lot, 7";
}else{
	$alert2 = $num2 . " spots open!";
	$script2 = "There are " . $alert2 . " in parking lot, 7";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Welcome to See Spot Park - TAMUK's campus parking tracking system." />
<link rel="stylesheet" type="text/css" media="all" href="css/style.css?ts=<?=time()?>" />
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
<script src='js/responsivevoice.js'></script><!-- this is for the voice output -->
<title>See. Spot. Park.</title>
</head>
<body>
<!-- below is the see spot park logo -->
<header class="header" >
</header>
<!-- below is the text seen on screen -->
<div style="color:black;" >Press the Green button and say: "<strong>Find me a spot</strong>", and we'll fetch the spot closest to you!</br>
Click a blue (<img src="images/mini.png" style="width:24px;" />) or red (<img src="images/mini_red.png" style="width:24px;" />) highlighted area and we'll tell you how many spots are available in that lot.</div>
<!-- below is the html <div> for the google map. -->
<div class="main_body" >
	<div id="map"></div>
</div>
<!-- below is a <div> for printing out the users lat. and long.  It is hidden for now. -->
<div style="color:black;visibility:collapse;" id="demo">hello</div>
<input type="button" name="button" class="button_click" value="press to find a spot" onclick="button_click()" />
<script>
	function button_click(){
		var audio = new Audio('beep.m4A');
		audio.play();
		annyang.start({ autoRestart: false });
	}
</script>
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
		// For now, the lat. and long. of the two parking lots are hard-coded.  They need to come from a database.
        var Parking_Lot_F = {lat: 27.526794, lng: -97.878555};
		var Parking_Lot_7 = {lat: 27.525213, lng: -97.878262};
		/* below, assign the PHP values of "$alert" and "$alert2" into the javascript variables label and label2
		respectively */
		var label = '<?php print $alert; ?>';
		var label2 = '<?php print $alert2; ?>';
		// below, a new map object is declared
        var map = new google.maps.Map(document.getElementById('map'), {
		  // the attributes of the map are set
          zoom: 19, // this is , obviously, the zoom level
		  zoomControl: false, // This removes the zoom control
          center: Parking_Lot_F // this sets the center at parking lot f, this needs to be set dynamically
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
		// a variable is declared to hold the position of the center of the map
		var center;
		// below, the "calculateCenter()" function is defined
		function calculateCenter() {
			// Again, this is hard-coded, but needs to be dynamic
		  center = Parking_Lot_F;
		}
		// the event listeners below listen for click actions on the markers (pins)
		google.maps.event.addDomListener(marker, 'click', function() {
		  // they cause the voice output to give the number of open spots in that lot, in particular.
		  responsiveVoice.speak("<?php print $script; ?>","US English Female");
		});
		google.maps.event.addDomListener(marker2, 'click', function() {
		  responsiveVoice.speak("<?php print $script2; ?>","US English Female");
		});
		/* the functions below are meant to calculate the center of the map on idle, and 
		recenter the map on window resize */
		google.maps.event.addDomListener(map, 'idle', function() {
		  calculateCenter();
		});
		google.maps.event.addDomListener(window, 'resize', function() {
		  map.setCenter(center);
		});
      }
 </script>
 <!-- the script below is for accessing the google maps API -->
	 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6zNJLvNxe39Wy3Kcd8wX2mJD31aPOJdQ&callback=initMap">
    </script>
<!-- this is just more text for the page (under the map)  -->
	<div class="instructions" ></br>You can also say "Refresh" to refresh the page.</div>
	<script src="js/annyang_speech.js"></script> <!-- this code calls the speech recognition javascript library "annyang_speech.js" -->
<!-- below is the script that runs if annyang has been succesfully loaded -->
	<script>
if (annyang) {
  // define the first command. First the text we expect, and then the function it should call
  var commands = {
    'Find me (a) spot(s)': function() {
		/* this math is incorrect */
		var lot_f_lat = 27.526794 - parseFloat(y[0]);
		var lot_f_long = -97.878555 - parseFloat(y[1]);
		var dist = Math.sqrt((lot_f_lat * lot_f_lat)+(lot_f_long * lot_f_long));
		if(dist<0){dist=dist*-1;}
		var lot_7_lat = 27.525213 - parseFloat(y[0]);
		var lot_7_long = -97.878262 - parseFloat(y[1]);
		var dist2 = Math.sqrt((lot_7_lat * lot_7_lat)+(lot_7_long * lot_7_long));
		if(dist2<0){dist2=dist2*-1;}
		/* this math is incorrect */
		// The code below is SUPPOSED to relay the nearest lot of the two via audio output
		if(dist > dist2){
			responsiveVoice.speak("<?php print $script2; ?>","US English Female");
			
		}else{
			responsiveVoice.speak("<?php print $script; ?>","US English Female");
		}
		annyang.pause();
    },
	// this command allows for hands-free updating of information
	'refresh (page)':function(){
		window.location.href = "https://www.thomaswurdinger.com/seespotpark";
		annyang.pause();
	},
	// this is because I can
	'thank you': function() {
     responsiveVoice.speak("You got it, dooooood!","US English Female");
	 annyang.pause();
    }
  };

  // Add our commands to annyang
  annyang.addCommands(commands);

  // Start listening. You can call this here, or attach this call to an event, button, etc.
  // It should probably be attached to a HUGE button
  //annyang.start({ autoRestart: true, continuous: true });
  
}
</script>
</body>
<hr><!--  visible pagebreak  
<!-- below is the footer -->
<footer class="footer" >
		&copy; See Spot Park | 2017
</footer>
</html>
<!-- EOF -->