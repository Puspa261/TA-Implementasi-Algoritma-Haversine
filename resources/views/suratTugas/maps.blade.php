<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/2.8.0/leaflet-search.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        #search-container {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background-color: white;
            padding: 5px;
        }

        #search-input {
            width: 200px;
            margin-right: 5px;
        }

        #search-btn {
            cursor: pointer;
        }
    </style>
    <title>Maps</title>
</head>

<body>
    <div id="search-container">
        <input type="text" id="search-input" placeholder="Search location...">
        <button id="search-btn">Search</button>
    </div><br><br><br>
    <button id="btn-show">Show Maps</button>
    <h1>OpenStreetMap</h1>
    <form class="container">
        <div class="mb-3">
            <label class="form-label" for="name-location">Lokasi</label>
            <input type="text" class="form-control" id="name-location" readonly name="location" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" readonly name="latitude" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" readonly name="longitude" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="search-input">Cari Lokasi</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="search-input" placeholder="Cari Nama Lokasi......">
                <button id="search-btn" class="btn btn-primary ms-2">Search</button>
            </div>
        </div>
        <div class="mb-3">
            <div id="map"></div>
        </div>
    </form>
    <div id="map"></div>
    <br><br><br><br>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/2.8.0/leaflet-search.min.js"></script>
    <script>
        $(document).ready(function() {
            var mymap = null;
            var marker = null;

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    mymap = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(mymap);

                    marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap)
                        .bindPopup('Your current location.')
                        .openPopup();

                    mymap.on('click', function(e) {
                        if (marker !== null) {
                            mymap.removeLayer(marker);
                        }

                        var longitude = e.latlng.lng;
                        var latitude = e.latlng.lat;

                        $("#longitude").val(longitude);
                        $("#latitude").val(latitude);

                        marker = L.marker([latitude, longitude]).addTo(mymap)
                            .bindPopup('Clicked location')
                            .openPopup();

                        $.getJSON('https://nominatim.openstreetmap.org/reverse?format=json&lat=' +
                            latitude + '&lon=' + longitude,
                            function(data) {
                                $("#name-location").val(data.display_name);
                            });
                    });

                    $("#search-btn").click(function(e) {
                        e.preventDefault();
                        var query = $("#search-input").val();
                        if (query.trim() !== "") {
                            searchLocation(query);
                        }
                    });

                    function searchLocation(query) {
                        $.getJSON('https://nominatim.openstreetmap.org/search?format=json&q=' +
                            encodeURIComponent(query),
                            function(data) {
                                if (data && data.length > 0) {
                                    var result = data[0];
                                    var latitude = parseFloat(result.lat);
                                    var longitude = parseFloat(result.lon);

                                    mymap.setView([latitude, longitude], 13);

                                    $("#name-location").val(result.display_name);
                                    $("#latitude").val(latitude);
                                    $("#longitude").val(longitude);

                                    if (marker !== null) {
                                        mymap.removeLayer(marker);
                                    }
                                    marker = L.marker([latitude, longitude]).addTo(mymap)
                                        .bindPopup('Searched location')
                                        .openPopup();
                                } else {
                                    alert("Location not found.");
                                }
                            });
                    }
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        });
    </script>
</body>

</html>
