@extends('layouts.main')
@section('content')
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Petugas tidak ditemukan!!!",
                });
            });
        </script>
    @endif
    <div class="container-xxl container-p-y">

        <div class="d-flex align-items-center py-2">
            <a href="{{ url()->previous() }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Pengaduan Masyarakat</h4>
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
                        <h5 class="mb-0">Detail Pengaduan Masyarakat</h5>
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

                    <?php
                    use Carbon\Carbon;
                    ?>

                    <div class="card-body">
                        <form action="{{ route('pengaduan_masyarakat.update', $pengaduan_masyarakat->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="jenis">Jenis</label>
                                <input type="text" class="form-control" id="jenis" name="jenis" readonly
                                    value="{{ $pengaduan_masyarakat->jenis }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-date">Tanggal</label>
                                <input type="text" class="form-control" id="name-date" readonly
                                    value="{{ Carbon::parse($pengaduan_masyarakat->created_at)->translatedFormat('d-m-Y') }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-time">Jam</label>
                                <input type="text" class="form-control" id="name-time" readonly
                                    value="{{ Carbon::parse($pengaduan_masyarakat->created_at)->translatedFormat('H:i:s') }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" readonly
                                    value="{{ $pengaduan_masyarakat->name }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-phone">Telepon</label>
                                <input type="text" class="form-control" id="name-phone" name="phone" readonly
                                    value="{{ $pengaduan_masyarakat->phone }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-image">Gambar</label>
                                <img src="/laporan/{{ $pengaduan_masyarakat->image }}" alt="pengaduan"
                                    class="d-block rounded" id="uploadedAvatar" style="width: 30%" name="image" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-message">Materi Pengaduan / Keluhan</label>
                                <textarea type="text" class="form-control" id="name-message" name="message" readonly>{{ $pengaduan_masyarakat->message }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-detail">Detail Lokasi</label>
                                <input type="text" class="form-control" id="name-detail" name="detail" readonly
                                    value="{{ $pengaduan_masyarakat->detail }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-location">Lokasi</label>
                                <input type="text" class="form-control" id="name-location" name="location" readonly
                                    value="{{ $pengaduan_masyarakat->location }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly
                                    value="{{ $pengaduan_masyarakat->latitude }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" readonly
                                    value="{{ $pengaduan_masyarakat->longitude }}" />
                            </div>

                            <div class="mb-3">
                                <label for="selectPegawai" class="form-label">Petugas</label>
                                <select id="selectPegawai" class="form-select" name="id_pegawai">
                                    <option></option>
                                    @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai['id'] }}"
                                            {{ $pegawai->id == $pengaduan_masyarakat->id_pegawai ? 'selected' : '' }}>
                                            {{ $pegawai['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <div id="map"></div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a type="button" class="btn btn-primary px-4"
                                        href="{{ url()->previous() }}">Back</a>
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                </div>
                            </div>
                        </form>
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
                var lat = parseFloat("{{ $pengaduan_masyarakat->latitude }}");
                var lng = parseFloat("{{ $pengaduan_masyarakat->longitude }}");
                var locationName = "{{ $pengaduan_masyarakat->location }}";

                mymap = L.map('map').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mymap);

                marker = L.marker([lat, lng]).addTo(mymap)
                    .openPopup();
            });
        </script>

    @endsection
