@extends('app')

@section('content')


<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

    </style>
    <title>Places search box</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>

var l;
    var map;
    var geocoder;
    var marker;
    var infowindow = new google.maps.InfoWindow();









  













function initialize() {
  
  var markers = [];
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
      
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }

  
  var input = (
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    (input));

 
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };
       crearMapa(place.geometry.location)

      markers.push(marker);

      
    }
  });
 
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
}

function handleNoGeolocation(errorFlag) {
          crearMapa();
}    
function search() {
          alert(document.getElementById("addressSearch").value);
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
             document.getElementById('pac-input').value = ""; 
            infowindow.close(map,marker);
            });

            google.maps.event.addListener(marker,'dragend',function(event) {
            document.getElementById('pac-input').value = ""; 
            infowindow.close(map,marker);
            });

}



google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <style>
      #target {
        width: 345px;
      }
    </style>
  </head>
  <body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                        <div id="map-canvas" style="width:auto;height:380px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body> 
</html>

@endsection
