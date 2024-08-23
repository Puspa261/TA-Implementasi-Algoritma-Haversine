@extends('layouts.main')
@section('content')
    <div class="container-xxl  container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('detail_regu.index') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Detail Regu</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Detail Regu</h5>
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
                        <form action="{{ route('detail_regu.update', $detail_regu->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="selectRegu" class="form-label mt-3">Regu
                                    <span class="star">*</span>
                                </label>
                                <select id="selectRegu" class="form-select" name="id_regu" required>
                                    @foreach ($regu as $rg)
                                        <option value="{{ $rg['id'] }}"
                                            {{ $rg['id'] == $detail_regu->id_regu ? 'selected' : '' }}>
                                            {{ $rg['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label mt-3">Jabatan Tugas
                                    <span class="star">*</span>
                                </label>
                                <select id="defaultSelect" class="form-select" name="id_jabatan_tugas" required>
                                    @foreach ($jabatan_tugas as $jt)
                                        <option value="{{ $jt['id'] }}"
                                        {{ $jt['id'] == $detail_regu->id_jabatan_tugas ? 'selected' : '' }}>
                                        {{ $jt['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Nama
                                    <span class="star">*</span>
                                </label>
                                <select id="basic-default-fullname" class="form-select" name="id_pegawai" required>
                                    @foreach ($user as $us)
                                        <option value="{{ $us['id'] }}"
                                        {{ $us['id'] == $detail_regu->id_pegawai ? 'selected' : '' }}>
                                        {{ $us['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4"
                                    href="{{ route('detail_regu.index') }}">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
