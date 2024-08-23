@extends('layouts.main')
@section('content')
    <style>
        .jabatan {
            min-width: 150px;
            word-break: break-word;
            white-space: normal;
        }

        @media (max-width: 768px) {
            .pegawai {
                min-width: 100px;
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
                <h4>Pegawai</h4>
            </div>
            <div class="pull-right">
                @can('admin-create')
                    <a class="btn btn-primary" href="{{ route('user.create') }}"> Tambahkan Pegawai</a>
                @endcan
            </div>
        </div>

        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header">Data Pegawai</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover data-table border">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIP / NRNPNSD</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->

        {{-- <hr class="my-5" /> --}}
    </div>

    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'number text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'pegawai break-word'
                    },
                    {
                        data: 'nip',
                        name: 'nip',
                        className: 'pegawai break-word'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan',
                        className: 'hide-mobile jabatan break-word'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
