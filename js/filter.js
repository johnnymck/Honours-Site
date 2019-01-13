var map;
var markers = [];

var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 56.469640, lng: -2.989296},
        zoom: 9
    });
};

$(function() {
    $('#filter').on('submit', function(e) {
        e.preventDefault();
        update();
    });
    function update() {
        clearMarkers();
        $('#list').empty();
        $.ajax({
            url: "search.json",
            data: $('#filter').serialize(),
            timeout: 3000,
            method: 'post',
            success: function(results) {
                var contentString;
                var infoWindow;
                $('#list').append('<p>' + results.length + ' results found:</p>');
                for (var i = 0; i < results.length; i++) {
                    $('#list').append('<li><a href="property/' + results[i].id + '">' + results[i].displayable_address + '</li><br><img src=' + results[i].image + '></a><br>');
                    var latLng = new google.maps.LatLng(results[i].latitude,results[i].longitude);
                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: map,
                        title: results[i].displayable_address,
                    });
                    infoWindow = new google.maps.InfoWindow();           
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function() {
                            infoWindow.setContent('<a href="property/' + results[i].id + '">'  + results[i].displayable_address + "</a>",);
                            infoWindow.open(map, marker);
                        }
                    })(marker, i));
                    markers.push(marker);
                }
            },
            error: function (request, status, error) {
                alert(status);
                alert(request.responseText);
            },
        });
    }
});

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }

  // Removes the markers from the map, but keeps them in the array.
  function clearMarkers() {
    setMapOnAll(null);
  }

  // Shows any markers currently in the array.
  function showMarkers() {
    setMapOnAll(map);
  }

  // Deletes all markers in the array by removing references to them.
  function deleteMarkers() {
    clearMarkers();
    markers = [];
  }
