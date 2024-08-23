@extends('layouts.main')
@section('content')
    <style>
        @media (max-width: 768px) {
            .detail-regu {
                min-width: 90px;
            }

            .nama-regu {
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
                <h4>Detail Regu</h4>
            </div>
            <div class="pull-right">
                @can('admin-create')
                    <a class="btn btn-primary" href="{{ route('detail_regu.create') }}">Tambahkan Detail Regu</a>
                @endcan
            </div>
        </div>

        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header">Data Detail Regu</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover data-table border">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama Regu</th>
                            <th class="text-center">Jabatan Tugas</th>
                            <th class="text-center">Anggota</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->

        <hr class="my-5" />
    </div>

    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('detail_regu.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'number text-center',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'regu',
                        name: 'regu',
                        className: 'nama-regu break-word'
                    },
                    {
                        data: 'jabatan_tugas',
                        name: 'jabatan_tugas',
                        className: 'detail-regu break-word'
                    },
                    {
                        data: 'user',
                        name: 'user',
                        className: 'detail-regu break-word'
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
