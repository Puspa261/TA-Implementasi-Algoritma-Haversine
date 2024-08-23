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
                        <div class="mb-3">
                            <label for="selectRegu" class="form-label mt-3">Regu</label>
                            <input type="text" class="form-control" id="basic-default-company"
                                value="{{ $detail_regu->regu->name }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label mt-3">Jabatan Tugas</label>
                            @foreach ($detail_regu->jabatan_tugas as $jt)
                                <input type="text" class="form-control" id="basic-default-company"
                                    value="{{ $jt->name }}" disabled />
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            @foreach ($detail_regu->user as $user)
                                <input type="text" class="form-control" id="basic-default-company"
                                    value="{{ $user->name }}" disabled />
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between">
                            <a type="button" class="btn btn-primary px-4" href="{{ route('detail_regu.index') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
