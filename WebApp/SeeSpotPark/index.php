<?php
$num = rand(0,10);
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
<body onload='responsiveVoice.speak("<?php print $script; ?>","US English Female");' >
<header class="header" >
</header>
<div class="main_body" >
	<div id="map"></div>
	<input class='button' onclick='responsiveVoice.speak("<?php print $script; ?>","US English Female");' type='button' value='🔊 Play' />
</div>


 <script>
      function initMap() {
        var Parking_Lot_F = {lat: 27.526697, lng: -97.878523};
		var label = '<?php print $alert; ?>';
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
		var center;
		function calculateCenter() {
		  center = Parking_Lot_F;
		}
		google.maps.event.addDomListener(marker, 'click', function() {
		  responsiveVoice.speak("<?php print $script; ?>","US English Female");
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
</body>
<footer class="footer" >
		&copy; See Spot Park | 2017
</footer>
</html>