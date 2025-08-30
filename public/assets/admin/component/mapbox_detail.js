mapboxgl.accessToken =
    "pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg";

document.addEventListener("DOMContentLoaded", function () {
    const mapEl = document.getElementById("map");
    if (!mapEl) return;

    const lat = parseFloat(mapEl.dataset.lat);
    const lng = parseFloat(mapEl.dataset.lng);

    // Validasi koordinat
    if (
        isNaN(lat) ||
        isNaN(lng) ||
        lat < -90 ||
        lat > 90 ||
        lng < -180 ||
        lng > 180
    ) {
        console.error("Koordinat tidak valid:", lat, lng);
        return;
    }

    const map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v12",
        center: [lng, lat],
        zoom: 14,
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

    // Append ke container jika ada
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
        map.resize();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                directions.setOrigin([userLng, userLat]);
                directions.setDestination([lng, lat]);

                getPlaceName(userLat, userLng);
            });
        }
    });

    function getPlaceName(lat, lng) {
        fetch(
            `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`
        )
            .then((response) => response.json())
            .then((data) => {
                const placeName = data.features[0]?.place_name;
                const originNameEl = document.getElementById("origin-name");
                if (originNameEl && placeName) {
                    originNameEl.innerText = placeName;
                }
            });
    }
});
