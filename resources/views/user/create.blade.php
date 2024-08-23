@extends('layouts.main')
@section('content')
    <div class="container-xxl  container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('user.index') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Pegawai</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pegawai Baru</h5>
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
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-image">Image</label>
                                <input type="file" class="form-control" id="basic-default-image" name="image" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Nama
                                    <span class="star">*</span>
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" name="name"
                                    required autofocus/>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nip">NIP / NRNPNSD
                                    <span class="star">*</span>
                                </label>
                                <input type="number" class="form-control" id="basic-default-nip" name="nip" required />
                            </div>

                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">Jabatan
                                    <span class="star">*</span>
                                </label>
                                <select id="defaultSelect" class="form-select" name="id_jabatan" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan['id'] }}">{{ $jabatan['detail'] }} {{ $jabatan['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="selectPangkat" class="form-label">Pangkat / Golongan</label>
                                <select id="selectPangkat" class="form-select" name="id_pangkat">
                                    <option value="">Belum Memiliki Pangkat / Golongan</option>
                                    @foreach ($pangkats as $pangkat)
                                        <option value="{{ $pangkat['id'] }}">{{ $pangkat['pangkat'] }} /
                                            {{ $pangkat['golongan'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address
                                    <span class="star">*</span>
                                </label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
                                    required />
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password
                                        <span class="star">*</span>
                                    </label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Confirm Password
                                        <span class="star">*</span>
                                    </label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password" class="form-control"
                                        name="confirm-password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="confirm-password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="defaultRole" class="form-label">Role
                                    <span class="star">*</span>
                                </label>
                                <select id="defaultRole" class="form-select" name="roles[]" required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4" href="{{ route('user.index') }}">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
