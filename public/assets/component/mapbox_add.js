mapboxgl.accessToken = 'pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg';

const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [104.03782, 1.10610],
    zoom: 16,
    maxZoom: 16,
    minZoom: 10 
});

var directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken,
    unit: 'metric',
    profile: 'mapbox/driving-traffic',
    controls: {
        instructions: true
    },
    routeOptions: {
        steps: true
    },
    language: 'id'
});

// Tambahkan kontrol arah ke dalam div "directions-container"
var directionsContainer = document.getElementById('directions-container');
directionsContainer.appendChild(directions.onAdd(map));

map.on('load', function () {
    map.resize();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            getPlaceName(lat, lng);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            directions.setOrigin([lng, lat]);

            map.on('moveend', function () {
                var center = map.getCenter();
                document.getElementById('latitude').value = center.lat.toFixed(5);
                document.getElementById('longitude').value = center.lng.toFixed(5);
            });
        });
    } else {
        alert("Geolokasi tidak didukung oleh browser ini.");
    }
});

function getPlaceName(lat, lng) {
    fetch(
        `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`
    )
        .then(response => response.json())
        .then(data => {
            const placeName = data.features[0].place_name;
            const originNameEl = document.getElementById('origin-name');
            if (originNameEl) {
                originNameEl.innerText = placeName;
            }
        })
        .catch(error => console.error('Terjadi kesalahan:', error));
}
