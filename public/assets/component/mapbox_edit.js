mapboxgl.accessToken = 'pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg';

document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('map');

    if (!mapElement) return;

    const lat = parseFloat(mapElement.dataset.lat);
    const lng = parseFloat(mapElement.dataset.lng);

    if (isNaN(lat) || isNaN(lng)) {
        console.error('Koordinat tidak valid di elemen map');
        return;
    }

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lng, lat], // [lng, lat] format
        zoom: 10,
        maxZoom: 16,
        minZoom: 10
    });

    const directions = new MapboxDirections({
        accessToken: mapboxgl.accessToken,
        interactive: true,
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

    const directionsContainer = document.getElementById('directions-container');
    if (directionsContainer) {
        directionsContainer.appendChild(directions.onAdd(map));
    }

    map.on('load', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                directions.setOrigin([userLng, userLat]);
                directions.setDestination([lng, lat]);

                getPlaceName(userLat, userLng);
            });
        } else {
            alert("Geolokasi tidak didukung oleh browser ini.");
        }
    });

    function getPlaceName(lat, lng) {
        fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`)
            .then(response => response.json())
            .then(data => {
                const placeName = data.features[0]?.place_name || 'Lokasi tidak ditemukan';
                const el = document.getElementById('origin-name');
                if (el) el.innerText = placeName;
            });
    }
});

// Fungsi toggle card
function toggleCard() {
    let card2 = document.getElementById('card2');
    if (card2) {
        card2.classList.toggle('active');
    }
}

// Tooltip fungsi
function showTooltip() {
    var tooltip = document.querySelector('.tooltip');
    if (tooltip) tooltip.style.visibility = 'visible';
}

function hideTooltip() {
    var tooltip = document.querySelector('.tooltip');
    if (tooltip) tooltip.style.visibility = 'hidden';
}
