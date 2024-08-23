@extends('layouts.main')
@section('content')
    <div class="container-xxl  container-p-y">
        <div class="d-flex align-items-center py-3  ">
            <a href="{{ route('user.index') }}" class="btn btn-icon back">
                <i class='bx bx-left-arrow-alt'></i>
            </a>
            <h4 class="pt-3 fw-bold mx-2">Detail</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Baru</h5>
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
                        <form action="{{ route('detail.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-date">Tanggal
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="date" id="basic-default-date" name="date"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-start">Jam Mulai
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="time" value="--:--:--" id="basic-default-start"
                                    name="started_at" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-end">Jam Selesai
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="time" value="--:--:--" id="basic-default-end"
                                    name="finished_at" required />
                            </div>

                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">Surat Tugas
                                    <span class="star">*</span>
                                </label>
                                <select id="defaultSelect" class="form-select" name="id_jabatan">
                                    @foreach ($surat_tugas as $st)
                                        <option value="{{ $st['id'] }}">{{ $st['location'] }} </option>
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
