@extends('layouts.main')
@section('content')
    <style>
        .dashboard {
            height: 12em;
        }
        
        .detail {
            color: #637687;
            text-align: center;
        }

        .judul {
            font-size: 19px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Perhatian {{ Auth::user()->name }}</h5>
                                <p style="margin-bottom: 4px">
                                    Sebelum memulai website, ada beberapa hal yang harus diperhatikan!
                                </p>
                                <ol class="list-group list-group-numbered">
                                    <li class="mb-1">Klik <a href="{{ route('surat_tugas_pegawai') }}"
                                            class="fw-bold">Surat Tugas</a> untuk melihat tugas yang diperintahkan</li>
                                    <li class="mb-1">Pastikan untuk selalu <a href="{{ route('lokasi.create') }}"
                                            class="fw-bold">Update Lokasi</a> saat sedang bertugas</li>
                                    <li class="mb-1">Jangan lupa untuk <a href="{{ route('lokasi.create') }}"
                                            class="fw-bold">Matikan Lokasi</a> saat akan <b>menanggapi pengaduan</b> dan
                                        saat <b>selesai bertugas</b>
                                    </li>
                                    <li>Tanggapi pengaduan pada halaman detail <a href="{{ route('pengaduan.pegawai') }}"
                                            class="fw-bold">Pengaduan Masyarakat</a></li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-4 order-1">
                <div class="row">

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.pg_all') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Total Pengaduan</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $all }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.pg_ditanggapi') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Ditanggapi</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $ditanggapi }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.pg_belum_ditanggapi') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Belum Ditanggapi</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $belum_ditanggapi }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
