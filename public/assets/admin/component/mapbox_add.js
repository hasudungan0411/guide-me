mapboxgl.accessToken =
    "pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg";

const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v12",
    center: [104.03782, 1.1061],
    zoom: 16,
    maxZoom: 16,
    minZoom: 10,
});

var directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken,
    unit: "metric",
    profile: "mapbox/driving",
    controls: {
        instructions: true,
    },
    routeOptions: {
        steps: true,
    },
    language: "id",
});

// Tambahkan kontrol arah ke dalam div "directions-container"
var directionsContainer = document.getElementById("directions-container");
directionsContainer.appendChild(directions.onAdd(map));

map.on("load", function () {
    map.addSource("traffic", {
        type: "vector",
        url: "mapbox://mapbox.mapbox-traffic-v1",
    });

    map.addLayer(
        {
            id: "traffic",
            type: "line",
            source: "traffic",
            "source-layer": "traffic",
            layout: {
                "line-join": "round",
                "line-cap": "round",
            },
            paint: {
                "line-width": 2,
                "line-color": [
                    "case",
                    ["==", ["get", "congestion"], "low"],
                    "#388E3C", // Hijau untuk lancar
                    ["==", ["get", "congestion"], "moderate"],
                    "#FBC02D", // Kuning untuk padat
                    ["==", ["get", "congestion"], "heavy"],
                    "#E64A19", // Oranye untuk macet
                    ["==", ["get", "congestion"], "severe"],
                    "#B71C1C", // Merah untuk macet parah
                    "#ccc", // Abu-abu jika tidak ada data
                ],
            },
        },
        "waterway-label"
    ); // Letakkan di atas layer lain agar terlihat
    map.resize();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            getPlaceName(lat, lng);

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;

            directions.setOrigin([lng, lat]);

            map.on("moveend", function () {
                var center = map.getCenter();
                document.getElementById("latitude").value =
                    center.lat.toFixed(5);
                document.getElementById("longitude").value =
                    center.lng.toFixed(5);
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
        .then((response) => response.json())
        .then((data) => {
            const placeName = data.features[0].place_name;
            const originNameEl = document.getElementById("origin-name");
            if (originNameEl) {
                originNameEl.innerText = placeName;
            }
        })
        .catch((error) => console.error("Terjadi kesalahan:", error));
}
