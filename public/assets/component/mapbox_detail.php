<script>
            mapboxgl.accessToken = 'pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg';

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [104.03782, 1.10610],
                zoom: 10,
                maxZoom: 16, 
                minZoom: 10 
            });

            var directions = new MapboxDirections({
                accessToken: mapboxgl.accessToken,
                interactive: false,
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

            // Menonaktifkan formulir input rute
            document.querySelector('.mapboxgl-ctrl-geocoder input').disabled = true;
            document.querySelector('.mapbox-directions-origin input').disabled = true;
            document.querySelector('.mapbox-directions-destination input').disabled = true;

            map.on('load', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;

                        // Mendapatkan nama tempat dari koordinat
                        getPlaceName(lat, lng);

                        directions.setOrigin([lng, lat]);
                        directions.setDestination([<?php echo $result['latitude']?>,<?php echo $result['longitude']?>]); 
                    });
                } else {
                    alert("Geolokasi tidak didukung oleh browser ini.");
                }
            });

            function getPlaceName(lat, lng) {
                fetch(
                        `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`)
                    .then(response => response.json())
                    .then(data => {
                        const placeName = data.features[0].place_name;
                        document.getElementById('origin-name').innerText = placeName;
                    })
            }
        </script>
		
		<script>
			function toggleCard() {
				let card2 = document.getElementById('card2');
				card2.classList.toggle('active');
			}
		</script>
		<script>
			try {
			// Kode yang mungkin menyebabkan kesalahan
			} catch (error) {
			if (!(error instanceof ErrorTypeToIgnore)) {
				throw error;
			}
			}


		</script>

        <script>
            function showTooltip() {
  var tooltip = document.querySelector('.tooltip');
  tooltip.style.visibility = 'visible';
}

function hideTooltip() {
  var tooltip = document.querySelector('.tooltip');
  tooltip.style.visibility = 'hidden';
}


        </script>

        