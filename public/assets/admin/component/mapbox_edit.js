mapboxgl.accessToken =
    "pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg";

document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById("map");

    if (!mapElement) return;

    const lat = parseFloat(mapElement.dataset.lat);
    const lng = parseFloat(mapElement.dataset.lng);

    if (isNaN(lat) || isNaN(lng)) {
        console.error("Koordinat tidak valid di elemen map");
        return;
    }

    const map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v12",
        center: [lng, lat],
        zoom: 10,
        maxZoom: 16,
        minZoom: 10,
    });

    const directions = new MapboxDirections({
        accessToken: mapboxgl.accessToken,
        interactive: false,
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

    const directionsContainer = document.getElementById("directions-container");
    if (directionsContainer) {
        directionsContainer.appendChild(directions.onAdd(map));
    }

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
        fetch(
            `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`
        )
            .then((response) => response.json())
            .then((data) => {
                const placeName =
                    data.features[0]?.place_name || "Lokasi tidak ditemukan";
                const el = document.getElementById("origin-name");
                if (el) el.innerText = placeName;
            });
    }
});

// Fungsi toggle card
function toggleCard() {
    let card2 = document.getElementById("card2");
    if (card2) {
        card2.classList.toggle("active");
    }
}

// Tooltip fungsi
function showTooltip() {
    var tooltip = document.querySelector(".tooltip");
    if (tooltip) tooltip.style.visibility = "visible";
}

function hideTooltip() {
    var tooltip = document.querySelector(".tooltip");
    if (tooltip) tooltip.style.visibility = "hidden";
}
