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
                        <h5 class="mb-0">Detail Surat Tugas</h5>
                    </div>

                    @if (session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                swal({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Pangkat Penandatangan Kosong!!!",
                                });
                            });
                        </script>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('surat_tugas_pdf', $id) }}" method="get" autocomplete="off">
                            @csrf

                            <div>
                                <label class="form-label" for="basic-default-nomor">Dasar
                                    <span class="star">*</span>
                                </label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dasar[]"
                                        value="Undang-Undang Republik Indonesia tentang Pemerintahan Daerah"
                                        id="Undang-Undang Republik Indonesia tentang Pemerintahan Daerah">
                                    <label class="form-check-label"
                                        for="Undang-Undang Republik Indonesia tentang Pemerintahan Daerah">
                                        Undang-Undang Republik Indonesia tentang Pemerintahan Daerah
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dasar[]"
                                        value="Peraturan Pemerintah Republik Indonesia tentang Satuan Polisi Pamong Praja"
                                        id="Peraturan Pemerintah Republik Indonesia tentang Satuan Polisi Pamong Praja">
                                    <label class="form-check-label"
                                        for="Peraturan Pemerintah Republik Indonesia tentang Satuan Polisi Pamong Praja">
                                        Peraturan Pemerintah Republik Indonesia tentang Satuan Polisi
                                        Pamong Praja
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dasar[]"
                                        value="Peraturan Menteri Dalam Negeri tentang Penyelenggaraan Ketertiban Umum dan Ketentraman Masyarakat"
                                        id="Peraturan Menteri Dalam Negeri tentang Penyelenggaraan Ketertiban Umum dan Ketentraman Masyarakat">
                                    <label class="form-check-label"
                                        for="Peraturan Menteri Dalam Negeri tentang Penyelenggaraan Ketertiban Umum dan Ketentraman Masyarakat">
                                        Peraturan Menteri Dalam Negeri tentang Penyelenggaraan
                                        Ketertiban Umum dan Ketentraman Masyarakat
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dasar[]"
                                        value="Peraturan Daerah Kota Palembang tentang Pembentukan Perangkat Daerah Kota Palembang"
                                        id="Peraturan Daerah Kota Palembang tentang Pembentukan Perangkat Daerah Kota Palembang">
                                    <label class="form-check-label"
                                        for="Peraturan Daerah Kota Palembang tentang Pembentukan Perangkat Daerah Kota Palembang">
                                        Peraturan Daerah Kota Palembang tentang Pembentukan
                                        Perangkat Daerah Kota Palembang
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label" for="basic-default-nomor">Tugas
                                    <span class="star">*</span>
                                </label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="tugas[]" value="Patroli"
                                        id="Patroli">
                                    <label class="form-check-label" for="Patroli">Patroli</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="tugas[]"
                                        value="Pelanggaran Peraturan Daerah Lainnya"
                                        id="Pelanggaran Peraturan Daerah Lainnya">
                                    <label class="form-check-label" for="Pelanggaran Peraturan Daerah Lainnya">
                                        Pelanggaran Peraturan Daerah Lainnya </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="tugas[]"
                                        value="Penegakan Perda/Perkada" id="Penegakan Perda/Perkada">
                                    <label class="form-check-label" for="Penegakan Perda/Perkada"> Penegakan Perda/Perkada
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="tugas[]" value="Penertiban"
                                        id="Penertiban">
                                    <label class="form-check-label" for="Penertiban"> Penertiban </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="tugas[]" value=""
                                        id="otherCheckbox">
                                    <input class="form-control" type="text" id="otherText">
                                </div>
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

    <script>
        $(document).ready(function() {
            $('#otherText').on('input', function() {
                var inputValue = $(this).val();
                $('#otherCheckbox').val(inputValue);
            });
        });
    </script>
@endsection
