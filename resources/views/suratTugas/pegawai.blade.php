@extends('layouts.main')
@section('content')
    <style>
        @media (max-width: 768px) {
            .lokasi {
                min-width: 200px;
            }

            .jam {
                min-width: 80px;
            }

        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="col-lg-12 margin-tb d-flex justify-content-between py-3">
            <div class="pull-left">
                <h4>Surat Tugas</h4>
            </div>
        </div>

        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header">Surat Tugas Pegawai</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover data-table border mx-4 mb-4">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center lokasi break-word">Lokasi</th>
                            <th class="text-center jam break-word">Jam Mulai</th>
                            <th class="text-center jam break-word">Jam Selesai</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat_tugas as $key => $st)
                            <tr>
                                <td class="text-center">{{ ++$key }}</td>
                                <td class="text-center">{{ $st->date }}</td>
                                <td class="lokasi break-word">{{ $st->location }}</td>
                                <td class="text-center jam break-word">{{ $st->started_at }}</td>
                                <td class="text-center jam break-word">{{ $st->finished_at }}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <a class="btn btn-info show-btn" href="{{ route('surat_tugas_show', $st->id) }}">
                                            <i class="bx bx-search-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->

        {{-- <hr class="my-5" /> --}}
    </div>
@endsection
