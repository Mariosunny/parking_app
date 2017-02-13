<?php
$num = rand(0,10);
$num2 = rand(0,10);
if($num==0){
	$bgColor = "https://thomaswurdinger.com/SeeSpotPark/images/marker_background_red.png";
}else{
	$bgColor = "https://thomaswurdinger.com/SeeSpotPark/images/marker_background.png";
}
if($num==1){
	$alert = $num . " spot open!";
	$script = "There is " . $alert . " in parking lot, F";
}else{
	$alert = $num . " spots open!";
	$script = "There are " . $alert . " in parking lot, F";
}if($num2==0){
	$bgColor2 = "https://thomaswurdinger.com/SeeSpotPark/images/lot_7_red.png";
}else{
	$bgColor2 = "https://thomaswurdinger.com/SeeSpotPark/images/lot_7.png";
}
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
<script src='js/responsivevoice.js'></script>
<title>See. Spot. Park.</title>
</head>
<body>
<header class="header" >
</header>
<div style="color:black;" >Just say: "<strong>Show me a spot</strong>", and we'll fetch the spot closest to you!</br>
Click a blue (<img src="images/mini.png" style="width:24px;" />) or red (<img src="images/mini_red.png" style="width:24px;" />) highlighted area and we'll tell you how many spots are available in that lot.</div>
<div class="main_body" >
	<div id="map"></div>
</div>
<div style="color:black;visibility:hidden;" id="demo">hello</div>
 <script>
	  var x = document.getElementById('demo');
	var ret = getLocation();
	var y=new Array();
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}
	function showPosition(position) {
		x.innerHTML = "{lat: " + position.coords.latitude + 
		", lng: " + position.coords.longitude + "}"; 
		y[0]=position.coords.latitude; 
		y[1]=position.coords.longitude; 
	}
      function initMap() {
        var Parking_Lot_F = {lat: 27.526794, lng: -97.878555};
		var Parking_Lot_7 = {lat: 27.525213, lng: -97.878262};
		var label = '<?php print $alert; ?>';
		var label2 = '<?php print $alert2; ?>';
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 19,
		  zoomControl: false,
          center: Parking_Lot_F
        });
		var icon = "<?php echo $bgColor; ?>";
        var marker = new google.maps.Marker({
          position: Parking_Lot_F,
          label:  {
			  text: label,
			  color: 'white'
			  },
		  icon: icon,
		  map: map
        });
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
		var center;
		function calculateCenter() {
		  center = Parking_Lot_F;
		}
		google.maps.event.addDomListener(marker, 'click', function() {
		  responsiveVoice.speak("<?php print $script; ?>","US English Female");
		});
		google.maps.event.addDomListener(marker2, 'click', function() {
		  responsiveVoice.speak("<?php print $script2; ?>","US English Female");
		});
		google.maps.event.addDomListener(map, 'idle', function() {
		  calculateCenter();
		});
		google.maps.event.addDomListener(window, 'resize', function() {
		  map.setCenter(center);
		});
      }
 </script>
	 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6zNJLvNxe39Wy3Kcd8wX2mJD31aPOJdQ&callback=initMap">
    </script>
	<div class="instructions" ></br>You can also say "Refresh" to refresh the page.</div>
	<script src="js/annyang_speech.js"></script>
<script>
if (annyang) {
  // Let's define our first command. First the text we expect, and then the function it should call
  var commands = {
    'Show me (a) spot(s)': function() {
		var lot_f_lat = 27.526794 - parseFloat(y[0]);
		var lot_f_long = -97.878555 - parseFloat(y[1]);
		var dist = Math.sqrt((lot_f_lat * lot_f_lat)+(lot_f_long * lot_f_long));
		if(dist<0){dist=dist*-1;}
		var lot_7_lat = 27.525213 - parseFloat(y[0]);
		var lot_7_long = -97.878262 - parseFloat(y[1]);
		var dist2 = Math.sqrt((lot_7_lat * lot_7_lat)+(lot_7_long * lot_7_long));
		if(dist2<0){dist2=dist2*-1;}
		if(dist > dist2){
			responsiveVoice.speak("<?php print $script2; ?>","US English Female");
			
		}else{
			responsiveVoice.speak("<?php print $script; ?>","US English Female");
		}
    },
	'refresh (page)':function(){
		window.location.href = "https://www.thomaswurdinger.com/seespotpark";
	},
	'thank you': function() {
     responsiveVoice.speak("You got it, dooooood!","US English Female");
    }
  };

  // Add our commands to annyang
  annyang.addCommands(commands);

  // Start listening. You can call this here, or attach this call to an event, button, etc.
  annyang.start({ autoRestart: true, continuous: true });
}
</script>
</body>
<hr>
<footer class="footer" >
		&copy; See Spot Park | 2017
</footer>
</html>