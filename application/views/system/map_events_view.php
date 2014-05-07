<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Using closures in event listeners</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
function initialize() {
  var mapOptions = {
    zoom: 4,
    center: new google.maps.LatLng(-25.363882, 131.044922),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Add 5 markers to the map at random locations
  var southWest = new google.maps.LatLng(-31.203405, 125.244141);
  var northEast = new google.maps.LatLng(-25.363882, 131.044922);

  var bounds = new google.maps.LatLngBounds(southWest, northEast);
  map.fitBounds(bounds);

  var lngSpan = northEast.lng() - southWest.lng();
  var latSpan = northEast.lat() - southWest.lat();

  for (var i = 0; i < 5; i++) {
    var position = new google.maps.LatLng(
        southWest.lat() + latSpan * Math.random(),
        southWest.lng() + lngSpan * Math.random());
    var marker = new google.maps.Marker({
      position: position,
      map: map
    });

    marker.setTitle((i + 1).toString());
    attachSecretMessage(marker, i);
  }
}

// The five markers show a secret message when clicked
// but that message is not within the marker's instance data
function attachSecretMessage(marker, num) {
  var message = ['This', 'is', 'the', 'secret', 'message'];
  var infowindow = new google.maps.InfoWindow({
    content: message[num]
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(marker.get('map'), marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>