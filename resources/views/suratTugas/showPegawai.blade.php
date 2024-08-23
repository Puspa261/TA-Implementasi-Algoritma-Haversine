@extends('layouts.main')
@section('content')

    <div class="container-xxl container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('surat_tugas_pegawai') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Surat Tugas</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Surat Tugas</h5>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mx-4 mb-0">
                            <strong>Whoops!</strong> There were some problems with your input.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-date">Tanggal</label>
                            <input class="form-control" type="date" id="basic-default-date"
                                value="{{ $surat_tugas->date }}" disabled />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-start">Jam Mulai</label>
                            <input class="form-control" type="time" value="{{ $surat_tugas->started_at }}"
                                id="basic-default-start" disabled />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-default-end">Jam Selesai</label>
                            <input class="form-control" type="time" value="{{ $surat_tugas->finished_at }}"
                                id="basic-default-end" disabled />
                        </div>

                        <div class="row addRegu">
                            <div class="col-md-4">
                                <label for="selectRegu" class="form-label mt-3">Regu</label>
                                <input class="form-control mb-1" type="text" value="{{ $regu ? $regu->name : '' }}"
                                    id="selectRegu" disabled />
                            </div>
                            <div class="col-md-8">
                                <label for="keterangan" class="form-label mt-3">Keterangan</label>
                                <!--<input type="text" id="keterangan" class="form-control mb-1"-->
                                <!--    value="{{ $detail->keterangan }}" disabled />-->
                                <textarea class="form-control" id="keterangan" disabled> {{ $detail->keterangan }} </textarea>
                            </div>
                        </div>

                        <div class="row anggota">
                            <div class="col-md-4">
                                <label for="selectRegu" class="form-label mt-3">Anggota</label>
                                @foreach ($regu->detail_regu as $detail)
                                    @foreach ($detail->user as $user)
                                        <input class="form-control mb-1" type="text" value="{{ $user->name }}"
                                            id="selectRegu" disabled />
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="col-md-8">
                                <label for="keterangan" class="form-label mt-3">Jabatan</label>
                                @foreach ($regu->detail_regu as $detail)
                                    @foreach ($detail->jabatan_tugas as $jt)
                                        <input type="text" id="keterangan" class="form-control mb-1"
                                            value="{{ $jt->name }}" disabled />
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="form-label" for="name-location">Lokasi</label>
                            <input type="text" class="form-control" id="name-location"
                                value="{{ $surat_tugas->location }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label for="selectPangkat" class="form-label">Tanda Tangan</label>
                            <input type="text" class="form-control" id="name-location"
                                value="{{ $surat_tugas->user->name }}" disabled />
                        </div>

                        <div class="d-flex justify-content-between">
                            <a type="button" class="btn btn-primary px-4"
                                href="{{ route('surat_tugas_pegawai') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
