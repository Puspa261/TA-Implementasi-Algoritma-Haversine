@extends('layouts.main')
@section('content')
    <div class="container-xxl  container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('jabatan.index') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Jabatan</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Jabatan</h5>
                    </div>
                    <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Keterangan</label>
                                <input type="text" class="form-control" id="basic-default-fullname" value="{{ $jabatan->detail }}" disabled/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">Nama</label>
                                <input type="text" class="form-control" id="basic-default-company" value="{{ $jabatan->name != null ? $jabatan->name : '-' }}" disabled />
                            </div>
                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4" href="{{ route('jabatan.index') }}">Back</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
