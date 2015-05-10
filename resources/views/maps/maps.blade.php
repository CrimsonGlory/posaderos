@extends('app')

@section('content')

<head>
    <style type="text/css">
      html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=">
    </script>
    <script type="text/javascript">
    var l;
    var map;
    var geocoder;
    var marker;
    var infowindow = new google.maps.InfoWindow();
    /*function initialize() {
          var myLatlng = new google.maps.LatLng(-34.60372,-58.38159);
          var mapOptions = {
            zoom: 17,
            center: myLatlng
          }
          var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          var marker = new google.maps.Marker({
              position: myLatlng,
              map: map,
              draggable:true,
              title: 'Soy un linyera, rescatenme!'
          });
          var infowindow = new google.maps.InfoWindow({
            content: 'hola'
            });
            google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
            var actual = marker.getPosition();
            infowindow.setContent(actual.toString());
            });

        }*/
function initialize() {
  geocoder = new google.maps.Geocoder();
  var mapOptions = {
    zoom: 17
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);
      crearMapa(pos);
      google.maps.event.addListener(marker, 'click', function() {
            //infowindow.open(map,marker);
            var actual = marker.getPosition();
            //infowindow.setContent(actual.toString());
            var input = actual.toString();
            input = input.replace('(', '');
            input = input.replace(')', '');
            alert(input);

            var latlngStr = input.split(',', 2);
             var lat = parseFloat(latlngStr[0]);
              var lng = parseFloat(latlngStr[1]);
              var latlng = new google.maps.LatLng(lat, lng);
              geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  if (results[1]) {
                    infowindow.setContent(results[1].formatted_address);
                    infowindow.open(map, marker);
                  } else {
                    alert('No results found');
                  }
                } else {
                  alert('Geocoder failed due to: ' + status);
                }
            
            });
          });
            google.maps.event.addListener(marker,'drag',function(event) {
            infowindow.close(map,marker);
            });

            google.maps.event.addListener(marker,'dragend',function(event) {
            infowindow.close(map,marker);
            });

    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
          
}

function handleNoGeolocation(errorFlag) {
          crearMapa();
}        
function crearMapa(position)
{
    if(position===undefined)
    {
      
      var pos = new google.maps.LatLng(-34.6, -58.38);
      alert('No tiene servicios de ubicacion activados');

    }
    else
    {
        var pos = position;
     }
        marker = new google.maps.Marker({
              position: pos,
              map: map,
              draggable:true,
              title: 'Usted esta aqui'
          });
            infowindow.setContent('hola');
            
            map.setCenter(pos);
}



google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
<div id="map-canvas" style="width:500px;height:380px;"></div>
  </body>

@endsection
