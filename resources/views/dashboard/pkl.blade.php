@extends('layouts.main')
@section('content')
    <style>
        @media (max-width: 768px) {
            .petugas {
                min-width: 100px;
            }

            .tanggal {
                min-width: 70px;
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
                <h4>Pengaduan Masyarakat</h4>
            </div>
            <div class="pull-right">
                @can('admin-create')
                    <a class="btn btn-primary" href="{{ route('cetak') }}"> Cetak Pengaduan</a>
                @endcan
            </div>
        </div>

        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header">Laporan Pengaduan Masyarakat</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover data-table border">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Petugas</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->

        {{-- <hr class="my-5" /> --}}
    </div>

    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.pkl') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'number text-center',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        className: 'tanggal break-word'
                    },
                    {
                        data: 'pegawai',
                        name: 'pegawai',
                        className: 'petugas break-word'
                    },
                    {
                        data: 'status',
                        name: 'status',
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
