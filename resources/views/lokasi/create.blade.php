@extends('layouts.main')
@section('content')
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        .btn {
            width: 10rem;
        }
    </style>
    <div class="container-xxl container-p-y">

        <div class="d-flex align-items-center py-2">
            <h4 class="fw-bold mx-2">Lokasi</h4>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Lokasi Petugas</h5>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mx-4 mb-0">
                            <strong>Whoops!</strong> There were some problems with your
                            input.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('lokasi.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="name-location">Status</label>
                                @if ($lokasi == null)
                                    <p class="form-control text-danger"> Lokasi Nonaktif </p>
                                    {{-- <input type="text" class="form-control text-danger" value="Lokasi Nonaktif"
                                        readonly /> --}}
                                @else
                                    <p class="form-control text-success"> Lokasi Aktif <br> <span class="text-black"> Lokasi
                                            : {{ $lokasi->location }} </span> </p>
                                    {{-- <input type="text" class="form-control text-success" value="Lokasi Aktif" readonly /> --}}
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-name">Nama</label>
                                <input class="form-control" type="text" id="basic-default-name" name="id_pegawai"
                                    value="{{ auth()->user()->id }}" hidden />
                                <input class="form-control" type="text" id="basic-default-name" name="nama"
                                    value="{{ $pegawai->name }}" readonly />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-location">Lokasi</label>
                                <input type="text" class="form-control" id="name-location" readonly name="location"
                                    required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" readonly name="latitude"
                                    required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" readonly name="longitude"
                                    required />
                            </div>

                            <div class="mb-3">
                                <div id="map"></div>
                            </div>

                            <div class="d-flex justify-content-between mb-1">
                                <button type="submit" class="btn btn-primary">Perbarui Lokasi</button>
                            </div>
                        </form>

                        @if ($lokasi != null)
                            <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary">Matikan Lokasi</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
