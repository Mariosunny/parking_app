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
<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
<title>See. Spot. Park.</title>
</head>
<body>
<header class="header" >
</header>
<div class="main_body" >
	<div id="map"></div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script>
if (annyang) {
  // Let's define our first command. First the text we expect, and then the function it should call
  var commands = {
    'Show me (a) spot(s)': function() {
     responsiveVoice.speak("<?php print $script; ?>","US English Female");
    },
	'refresh (page)':function(){
		window.location.href = "https://www.thomaswurdinger.com/seespotpark";
	},
	'thank you': function() {
     responsiveVoice.speak("You're welcome!","US English Female");
    }
  };

  // Add our commands to annyang
  annyang.addCommands(commands);

  // Start listening. You can call this here, or attach this call to an event, button, etc.
  annyang.start({ autoRestart: true, continuous: true });
}
</script>
 <script>
      function initMap() {
        var Parking_Lot_F = {lat: 27.526794, lng: -97.878555};
		var Parking_Lot_7 = {lat: 27.525182, lng: -97.878262};
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
          label: label,
		  icon: icon,
		  map: map
        });
		var icon2 = "<?php echo $bgColor2; ?>";
		var marker2 = new google.maps.Marker({
          position: Parking_Lot_7,
          label: label2,
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
</body>
<hr>
<footer class="footer" >
		&copy; See Spot Park | 2017
</footer>
</html>