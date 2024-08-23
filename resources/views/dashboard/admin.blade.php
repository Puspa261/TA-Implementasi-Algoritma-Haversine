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
        
        * {
            /*border: 1px solid black;*/
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col">

            <!--<div class="col-lg-12 mb-4 order-0">-->
            <!--    <div class="card">-->
            <!--        <div class="d-flex align-items-end row">-->
            <!--            <div class="col-sm-7">-->
            <!--                <div class="card-body">-->
            <!--                    <h5 class="card-title text-primary">Congratulations John! 🎉</h5>-->
            <!--                    <p class="mb-4">-->
            <!--                        You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in-->
            <!--                        your profile.-->
            <!--                    </p>-->

            <!--                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-sm-5 text-center text-sm-left">-->
            <!--                <div class="card-body pb-0 px-0 px-md-4">-->
            <!--                    <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"-->
            <!--                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"-->
            <!--                        data-app-light-img="illustrations/man-with-laptop-light.png" />-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="col-lg-12 col-md-4 order-1">
                <div class="row">

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.all') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Total Pengaduan</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $all }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.ditanggapi') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Ditanggapi</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $ditanggapi }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.belum_ditanggapi') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Belum Ditanggapi</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $belum_ditanggapi }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.pkl') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Pedagang Kaki Lima</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $pk5 }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.gepeng') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Anak Jalanan dan Pengemis</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $gepeng }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.pembangunan') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Pembangunan Tanpa Izin</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $pembangunan }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.parkir') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Parkir Liar</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $parkir }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card dashboard">
                            <a href="{{ route('dashboard.kebisingan') }}" class="card-body d-block">
                                <div class="card-title d-flex flex-column">
                                    <span class="fw-semibold d-block my-1 detail judul">Kebisingan Malam</span>
                                    <h2 class="card-title text-nowrap mb-0 detail">{{ $kebisingan }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
