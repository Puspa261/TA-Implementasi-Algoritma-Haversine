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
                        <h5 class="mb-0">Surat Tugas Baru</h5>
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
                        <form action="{{ route('surat_tugas.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nomor">Nomor Surat
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="text" id="basic-default-nomor" name="nosurat"
                                    required autofocus/>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-date">Tanggal
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="date" id="basic-default-date" name="date"
                                    value="dd-mm-yyyy" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-start">Jam Mulai
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="time" value="--:--" id="basic-default-start"
                                    name="started_at" required />
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="basic-default-end">Jam Selesai
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="time" value="--:--" id="basic-default-end"
                                    name="finished_at" required />
                            </div>

                            <div class="row addRegu">
                                <div class="col-md-4">
                                    <label for="selectRegu" class="form-label mt-3">Regu <span
                                            class="star">*</span></label>
                                    <select id="selectRegu" class="form-select" name="id_regu[]" required>
                                        <option value="">Pilih Regu</option>
                                        @foreach ($regu as $rg)
                                            <option value="{{ $rg['id'] }}">{{ $rg['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label for="keterangan" class="form-label mt-3">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan[]"></textarea>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="addColumnBtn"
                                        class="btn btn-primary btn-sm px-3 mt-5">+</button>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label" for="name-location">Lokasi</label>
                                <input type="text" class="form-control" id="name-location" name="location" />
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label" for="basic-default-nomor">Titik Kumpul</label>
                                <input class="form-control" type="text" id="basic-default-nomor" name="tikum"
                                    placeholder="cth: Berkumpul di Kantor Satpol PP Kota Palembang." />
                            </div>

                            <div class="mb-3">
                                <label for="selectPangkat" class="form-label">Tanda Tangan
                                    <span class="star">*</span>
                                </label>
                                <select id="selectPangkat" class="form-select" name="id_pegawai" required>
                                    <option value="">Pilih Penandatangan...</option>
                                    @foreach ($user as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-date">Tanggal Pembuatan
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="date" id="basic-default-date"
                                    name="tanggal_pembuatan" value="dd/mm/yyyy" required />
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

    {{-- Tambah Pegawai --}}
    <script>
        $(document).ready(function() {
            // console.log('haloo');
            $('#addColumnBtn').click(function() {
                var newColumn =
                    '<div class="row addedColumn">' +

                    '<div class="col-md-4">' +
                    '<label for="selectRegu" class="form-label mt-3">Regu <span class="star">*</span></label>' +
                    '<select id="selectRegu" class="form-select" name="id_regu[]" required>' +

                    '<option value="">Pilih Regu</option>' +
                    '@foreach ($regu as $rg)' +
                    '<option value="{{ $rg['id'] }}">{{ $rg['name'] }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</div>' +

                    '<div class="col-md-7">' +
                    '<label for="keterangan" class="form-label mt-3">Keterangan <span class="star">*</span></label>' +
                    '<textarea class="form-control" id="keterangan" name="keterangan[]"></textarea>' +
                    '</div>' +

                    '<div class="col-md-1">' +
                    '<button type="button" class="btn btn-danger btn-sm px-3 mt-5 removeColumnBtn">-</button>' +
                    '</div>' +

                    '</div>';
                $(newColumn).insertAfter('.addRegu');
            });
            $(document).on('click', '.removeColumnBtn', function() {
                $(this).closest('.addedColumn').remove();
            });
        });
    </script>


@endsection
