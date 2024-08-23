@extends('layouts.main')
@section('content')
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        .custom-btn {
            width: 150px;
            margin-bottom: 10px;
        }

        .row {
            --bs-gutter-x: 0 !important;
        }

        * {
            /* border: 1px solid black; */
        }
    </style>
    <div class="container-xxl container-p-y">

        <div class="d-flex align-items-center py-2">
            @if (Gate::check('admin-list'))
                <a href="{{ url()->previous() }}" class="btn btn-icon back">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            @else
                <a href="{{ route('pengaduan.pegawai') }}" class="btn btn-icon back">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            @endif
            <h4 class="fw-bold mx-2 mt-3">Pengaduan Masyarakat</h4>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <?php
        use Carbon\Carbon;
        ?>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card">
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

                    <div class="card-body mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="jenis">Jenis</label>
                            <input type="text" class="form-control" id="jenis" disabled
                                value="{{ $pengaduan_masyarakat->jenis }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-date">Tanggal</label>
                            <input type="text" class="form-control" id="name-date" disabled
                                value="{{ Carbon::parse($pengaduan_masyarakat->created_at)->translatedFormat('d-m-Y / H:i:s') }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name">Nama</label>
                            <input type="text" class="form-control" id="name" disabled
                                value="{{ $pengaduan_masyarakat->name }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-phone">Telepon</label>
                            <input type="text" class="form-control" id="name-phone" disabled
                                value="{{ $pengaduan_masyarakat->phone }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-image">Gambar</label>
                            <img src="/laporan/{{ $pengaduan_masyarakat->image }}" alt="pengaduan" class="d-block rounded"
                                id="uploadedAvatar" style="width: 70%" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-message">Materi Pengaduan / Keluhan</label>
                            <textarea type="text" class="form-control" id="name-message" disabled>{{ $pengaduan_masyarakat->message }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-detail">Detail Lokasi</label>
                            <input type="text" class="form-control" id="name-detail" disabled
                                value="{{ $pengaduan_masyarakat->detail }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-location">Lokasi</label>
                            <input type="text" class="form-control" id="name-location" disabled
                                value="{{ $pengaduan_masyarakat->location }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" disabled
                                value="{{ $pengaduan_masyarakat->latitude }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" disabled
                                value="{{ $pengaduan_masyarakat->longitude }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name-user">Petugas</label>
                            @if ($pengaduan_masyarakat->pegawai != null)
                                @foreach ($pengaduan_masyarakat->pegawai as $pegawai)
                                    <input type="text" class="form-control" id="name-user" disabled
                                        value="{{ $pegawai->name }}" />
                                @endforeach
                            @else
                                <input type="text" class="form-control" id="name-user" disabled value="-" />
                            @endif
                        </div>

                        <div>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tindak Lanjut --}}
        @if ($tindakan)
            <div class="row mt-4">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tindak Lanjut</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name-tl">Tindak Lanjut</label>
                                <input type="text" class="form-control" id="name-tl" disabled
                                    value="{{ Carbon::parse($tindakan->created_at)->translatedFormat('d-m-Y') }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name-image">Gambar</label>
                                <img src="/tindak_lanjut/{{ $tindakan->image }}" alt="tindakan" class="d-block rounded"
                                    id="uploadedAvatar" style="width: 70%;" />
                            </div>

                            <div>
                                <label class="form-label" for="name-message">Deskripsi Tanggapan</label>
                                <textarea type="text" class="form-control" id="name-message" disabled>{{ $tindakan->detail }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                @if (Gate::check('admin-list'))
                    <a type="button" class="btn btn-primary px-4 mt-3" href="{{ url()->previous() }}">Back</a>
                @else
                    <a type="button" class="btn btn-primary px-4 mt-3" href="{{ route('pengaduan.pegawai') }}">Back</a>
                @endif
            </div>
        @else
            <div class="mb-3">
                <div class="d-flex justify-content-left">
                    <div class="row mt-3">
                        @if (Gate::check('admin-list'))
                            <div class="col me-1">
                                <a type="button" class="btn btn-primary custom-btn"
                                    href="{{ url()->previous() }}">Back</a>
                            </div>
                        @else
                            <div class="col me-1">
                                <a type="button" class="btn btn-primary custom-btn"
                                    href="{{ route('pengaduan.pegawai') }}">Back</a>
                            </div>
                        @endif
                        @if ($pengaduan_masyarakat->id_pegawai != null && $pegawaiId == $pengaduan_masyarakat->id_pegawai)
                            <!--<div class="col me-1">-->
                            <!--    <a type="button" class="btn btn-primary custom-btn" target="_blank"-->
                            <!--        href="http://www.google.com/maps/place/{{ $pengaduan_masyarakat->latitude }},{{ $pengaduan_masyarakat->longitude }}">Open-->
                            <!--        Gmaps</a>-->
                            <!--</div>-->
                            <div class="col me-1">
                                <a type="button" class="btn btn-primary custom-btn" target="_blank"
                                    href="https://wa.me/{{ $pengaduan_masyarakat->phone }}?text=Halo, saya yang akan menanggapi pengaduan anda! Mohon ditunggu">WhatsApp</a>
                            </div>
                            <div class="col me-1">
                                <a type="button" class="btn btn-primary custom-btn"
                                    href="{{ route('tindak_lanjut.create', ['id' => $pengaduan_masyarakat->id]) }}">Tanggapi</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

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
