<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export</title>
    <style>
        .main {
            padding-top: 30px;
        }

        @page :first {
            margin: 0 0 50px 0;
        }

        @page {
            margin: 150px 0 0 0;
        }

        .table td:first-child {
            vertical-align: top;
        }

        .table.pengaduan {
            border-collapse: collapse;
            width: 89%;
            margin-left: 36px;
        }

        .table.pengaduan th,
        .table.pengaduan td {
            border: 1px solid #000;
            text-align: left;
            padding: 10px;
        }

        * {
            /* border: 1px solid black; */
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="main">
        <div class="row my-3">
            <div class="col-lg-12 margin-tb">
                <center>
                    <h5 class="margin fw-bold">DATA LAPORAN PENGADUAN MASYARAKAT <br> SATPOL PP KOTA PALEMBANG</h5>
                </center>
            </div>
        </div>

        <div>
            <table class="table pengaduan">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Pengaduan</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">Petugas</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    use Carbon\Carbon;
                    ?>
                    @foreach ($pengaduan_masyarakat as $key => $pm)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ Carbon::parse($pm->created_at)->translatedFormat('d/m/Y') }}</td>
                            <td>{{ $pm->name }} <br> {{ $pm->phone }}</td>
                            <td>{{ $pm->message }}</td>
                            <td>{{ $pm->detail }}</td>
                            @if ($pm->pegawai->isNotEmpty())
                                @foreach ($pm->pegawai as $pg)
                                    <td>{{ $pg->name }}</td>
                                @endforeach
                            @else
                                <td>-</td>
                            @endif
                            @if ($pm->status == 0)
                                <td style="color: red">belum ditanggapi</td>
                            @else
                                <td style="color: green">sudah ditanggapi</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>
