@extends('layouts.main')
@section('content')
    <div class="container-xxl container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('user.index') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Pegawai</h4>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pegawai</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-image">Image</label>
                            <div class="col-md-9">
                                <div class="card border" style="max-width: 14rem; max-height: 14rem;">
                                    <img src="/imageUser/{{ $user->image }}" class="card-img" alt="image"
                                        style="max-width: 14rem; max-height: 14rem; object-fit: cover">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ $user->name }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nip">NIP / NRNPNSD</label>
                            <input type="text" class="form-control" id="basic-default-nip" value="{{ $user->nip }}"
                                disabled />
                        </div>

                        <div class="mb-3">
                            <label for="basic-default-jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="basic-default-jabatan"
                                value="{{ $user->jabatan->detail }} {{ $user->jabatan->name }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label for="basic-default-pangkat" class="form-label">Pangkat / Golongan</label>
                            <input type="text" class="form-control" id="basic-default-pangkat"
                                value="{{ $user->pangkat != null ? $user->pangkat->pangkat . ' / ' . $user->pangkat->golongan : '-' }}"
                                disabled />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1"
                                value="{{ $user->email }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-role">Role</label>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <input type="text" class="form-control" id="basic-default-role"
                                        value="{{ $v }}" disabled />
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (count($lokasis) > 0)
            <div class="row">
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Histori Lokasi</h5>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover data-table border mb-3">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Lokasi</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lokasis as $key => $lokasi)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td>{{ $lokasi->created_at }}</td>
                                            <td>{{ $lokasi->location }}</td>
                                            <td>
                                                <a class="btn btn-info show-btn"
                                                    href="{{ route('show.lokasi', $lokasi->id) }}">
                                                    <i class="bx bx-search-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between">
            <a type="button" class="btn btn-primary px-4" href="{{ route('user.index') }}">Back</a>
        </div>
    </div>
@endsection
