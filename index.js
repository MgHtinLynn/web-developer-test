let map;
let url = "https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_day.geojson";

async function initMap() {
    //fetch the data from api
    const data = await fetch(url).then((res) => res.json());
    // get the exact data from api
    const lists = data['features'];
    //declar the map init and add center lat and lng, zoom
    map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: 34.397,
            lng: 31.644
        },
        zoom: 3,
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    // loop the lists from api
    for (i = 0; i < lists.length; i++) {  
        //add maker to google map
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(lists[i]['geometry']['coordinates'][1], lists[i]['geometry']['coordinates'][0]),
          map: map
        });
        //add clickable for info-window open
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(lists[i]['properties']['title'] + '</br>' + new Date(lists[i]['properties']['time']).toString());
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
}