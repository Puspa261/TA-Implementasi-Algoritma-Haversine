<script>
    $(document).ready(function() {

// Select Pegawai
$("#selectPegawai").select2({
    placeholder: 'Pilih Pegawai',
    ajax: {
        url: "{{ route('surat_tugas.pegawai') }}",
        processResults: function({
            data
        }) {
            return {
                results: $.map(data, function(item) {
                    return {
                        id: item.id,
                        text: item.name
                    }
                })
            }
        }
    }
})

// Map
var mymap = null;
var marker = null;
var searchControl = null;

if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
        mymap = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap)
            .bindPopup('Your current location.', {
                autoClose: false
            })
            .openPopup();

        // Set nilai otomatis untuk #name-location berdasarkan koordinat saat ini
        $.getJSON('https://nominatim.openstreetmap.org/reverse?format=json&lat=' +
            position.coords.latitude + '&lon=' + position.coords.longitude,
            function(data) {
                $("#name-location").val(data.display_name);
            });

        // Set nilai otomatis untuk latitude dan longitude
        $("#longitude").val(position.coords.longitude);
        $("#latitude").val(position.coords.latitude);

        // Event listener untuk memverifikasi popup tetap terbuka saat klik di tempat lain di peta
        mymap.on('click', function(e) {
            marker.bindPopup('Your current location.', {
                autoClose: false
            }).openPopup();
        });
    });
} else {
    alert("Geolocation is not supported by your browser.");
}
})
</script>
<form action="{{ route('lokasi.create') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label" for="basic-default-name">Nama</label>
        <input hidden class="form-control" type="text" id="basic-default-name" name="id_pegawai"
            value="{{ auth()->user()->id }}" hidden />
        <input hidden class="form-control" type="text" id="basic-default-name" name="nama"
            value="{{ $pegawai->name }}" readonly />
    </div>
    <div class="mb-3">
        <label class="form-label" for="name-location">Lokasi</label>
        <input hidden type="text" class="form-control" id="name-location" readonly name="location"
            required />
    </div>
    <div class="mb-3">
        <label class="form-label" for="latitude">Latitude</label>
        <input hidden type="text" class="form-control" id="latitude" readonly name="latitude"
            required />
    </div>
    <div class="mb-3">
        <label class="form-label" for="longitude">Longitude</label>
        <input hidden type="text" class="form-control" id="longitude" readonly name="longitude"
            required />
    </div>
    <div class="mb-3">
        <div id="map"></div>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary px-4">Update Location</button>
    </div>
</form>
