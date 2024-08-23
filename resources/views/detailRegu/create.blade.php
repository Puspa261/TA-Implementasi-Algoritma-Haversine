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
                        <h5 class="mb-0">Detail Regu Baru</h5>
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
                        <form action="{{ route('detail_regu.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="selectRegu" class="form-label mt-3">Regu
                                    <span class="star">*</span>
                                </label>
                                <select id="selectRegu" class="form-select" name="id_regu" required>
                                    <option value="">Pilih Regu</option>
                                    @foreach ($regu as $rg)
                                        <option value="{{ $rg['id'] }}">{{ $rg['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label mt-3">Jabatan Tugas
                                    <span class="star">*</span>
                                </label>
                                <select id="defaultSelect" class="form-select" name="id_jabatan_tugas" required>
                                    <option value="">Pilih Jabatan Tugas</option>
                                    @foreach ($jabatan_tugas as $jt)
                                        <option value="{{ $jt['id'] }}">{{ $jt['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Nama
                                    <span class="star">*</span>
                                </label>
                                <select id="selectPegawai" class="form-select select2" name="id_pegawai[]"
                                    multiple="multiple" required></select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4" href="{{ route('detail_regu.index') }}">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Select Pegawai
            $("#selectPegawai").select2({
                placeholder: 'Pilih Pegawai',
                ajax: {
                    url: "{{ route('surat_tugas.pegawai') }}",
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            })
        })
    </script>
@endsection
