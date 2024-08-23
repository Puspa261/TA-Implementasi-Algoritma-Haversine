@extends('layouts.main')
@section('content')
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <div class="container-xxl container-p-y">

        <div class="d-flex align-items-center py-2">
            <a href="{{ url()->previous() }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Histori Lokasi</h4>
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
                        @foreach ($histori_lokasi->pegawai as $pegawai)
                            <h5 class="mb-0">Detail Lokasi {{ $pegawai->name }}</h5>
                        @endforeach
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
                        <div class="mb-3">
                            <label class="form-label" for="name-location">Lokasi</label>
                            <input type="text" class="form-control" id="name-location" disabled
                                value="{{ $histori_lokasi->location }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" disabled
                                value="{{ $histori_lokasi->latitude }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" disabled
                                value="{{ $histori_lokasi->longitude }}" />
                        </div>

                        <div class="mb-3">
                            <div id="map"></div>
                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4 mt-3" href="{{ url()->previous() }}">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {

                // Map
                var mymap = null;
                var marker = null;
                var searchControl = null;

                // Inisialisasi peta dengan nilai dari lokasi
                var lat = parseFloat("{{ $histori_lokasi->latitude }}");
                var lng = parseFloat("{{ $histori_lokasi->longitude }}");
                var locationName = "{{ $histori_lokasi->location }}";

                mymap = L.map('map').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mymap);

                marker = L.marker([lat, lng]).addTo(mymap)
                    .openPopup();
            });
        </script>

    @endsection
