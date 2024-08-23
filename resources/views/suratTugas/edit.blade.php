@extends('layouts.main')
@section('content')

    <div class="container-xxl container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('surat_tugas.index') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Surat Tugas</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Surat Tugas</h5>
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
                        <form action="{{ route('surat_tugas.update', $surat_tugas->id) }}" method="POST"
                            autocomplete="off">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nomor">Nomor Surat
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="text" id="basic-default-nomor" name="nosurat"
                                    value="{{ $surat_tugas->nosurat }}" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-date">Tanggal
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="date" id="basic-default-date" name="date"
                                    value="{{ $surat_tugas->date }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-start">Jam Mulai
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="time" value="{{ $surat_tugas->started_at }}"
                                    id="basic-default-start" name="started_at" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-default-end">Jam Selesai
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="time" value="{{ $surat_tugas->finished_at }}"
                                    id="basic-default-end" name="finished_at" />
                            </div>

                            <div class="row addRegu">
                                <div class="col-md-4">
                                    <label for="selectRegu" class="form-label mt-3">Regu <span class="star">*</span></label>
                                    @foreach ($regus as $regu)
                                        <input class="form-control mb-1" type="text" value="{{ $regu ? $regu->name : '' }}"
                                            id="selectRegu" disabled />
                                    @endforeach
                                </div>
                                <div class="col-md-8">
                                    <label for="keterangan" class="form-label mt-3">Keterangan <span
                                            class="star">*</span></label>
                                    @foreach ($details as $detail)
                                        <!--<input type="text" id="keterangan" class="form-control mb-1"-->
                                        <!--    value="{{ $detail->keterangan }}" disabled />-->
                                        <textarea class="form-control mb-1" id="keterangan" rows="1" disabled>{{ $detail->keterangan }}</textarea>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label" for="name-location">Lokasi</label>
                                <input type="text" class="form-control" id="name-location" name="location"
                                    value="{{ $surat_tugas->location }}" />
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label" for="basic-default-nomor">Titik Kumpul</label>
                                <input class="form-control" type="text" id="basic-default-nomor" name="tikum"
                                    value="{{ $surat_tugas->tikum }}"/>
                            </div>

                            <div class="mb-3">
                                <label for="selectPangkat" class="form-label">Tanda Tangan</label>
                                <select id="selectPangkat" class="form-select" name="id_pegawai">
                                    <option value="">Pilih Penandatangan...</option>
                                    @foreach ($user as $user)
                                        <option value="{{ $user['id'] }}"
                                            {{ $user->id == $surat_tugas->id_pegawai ? 'selected' : '' }}>{{ $user['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-date">Tanggal Pembuatan
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="date" id="basic-default-date" name="tanggal_pembuatan"
                                    value="{{ $surat_tugas->tanggal_pembuatan }}" required />
                            </div>

                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4"
                                    href="{{ route('surat_tugas.index') }}">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
