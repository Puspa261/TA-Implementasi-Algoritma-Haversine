<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export</title>
    <style>
        .dasar {
            margin-left: 30px;
            width: 95% !important;
        }

        .detailTugas {
            margin-left: 18px;
        }

        .logo {
            width: 100%;
        }

        .main {
            padding: 50px 50px 0 80px;
        }

        .margin {
            margin: 1px;
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

        .table.regu {
            border-collapse: collapse;
            width: 91%;
            margin-left: 60px;
        }

        .table.regu th,
        .table.regu td {
            border: 1px solid #000;
            padding: 5px 0 5px 3px;
            font-size: 14px;
        }

        * {
            /* border: 1px solid black; */
            font-size: 15px;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="main">
        <div class="row mb-3">
            <div class="col-lg-12 margin-tb">
                <center>
                    <h6 class="margin fw-bold">SURAT TUGAS</h6>
                    <p class="margin fw-bold">NOMOR : {{ $surat_tugas->nosurat }}</p>
                </center>
            </div>
        </div>

        <?php
        $i = 'a';
        ?>
        <span class="fw-bold mt-3">Undang-Undang : </span>
        <table class="table dasar">
            @foreach ($dasar as $item)
                <tr>
                    <td>{{ $i++ }}.</td>
                    <td>{{ $item }}</td>
                </tr>
            @endforeach
        </table>

        <div>
            <h6 class="text-center fw-bold">MEMERINTAHKAN</h6>
            <p class="fw-bold mb-0">Kepada :</p>

            @php
                $hasKeterangan = $details->whereNotNull('keterangan')->count() > 0;
            @endphp

            <table class="table regu {{ $hasKeterangan ? 'has-keterangan' : '' }}">
                <thead>
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Jabatan</th>
                        @if ($hasKeterangan)
                            <th class="text-center keterangan-header">Keterangan</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        @php
                            $firstRowInRegu = true;
                            $j = 1;
                        @endphp

                        @foreach ($detail->regu->detail_regu as $dt)
                            @foreach ($dt->user as $user)
                                <tr>
                                    @if ($firstRowInRegu)
                                        <td class="fw-bold">{{ $j++ }}. {{ $user->name }}</td>
                                    @else
                                        <td>{{ $j++ }}. {{ $user->name }}</td>
                                    @endif

                                    @foreach ($dt->jabatan_tugas as $jt)
                                        @if ($firstRowInRegu)
                                            <td class="text-center fw-bold">{{ $jt->name }}</td>
                                        @else
                                            <td class="text-center">{{ $jt->name }}</td>
                                        @endif
                                    @endforeach

                                    @if ($firstRowInRegu && $hasKeterangan)
                                        <td class="text-center">
                                            {!! nl2br(e($detail->keterangan)) !!}
                                        </td>
                                        @php
                                            $firstRowInRegu = false;
                                        @endphp
                                    @elseif ($hasKeterangan)
                                        <td class="text-center"></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <p class="fw-bold mb-0">Untuk : </p>
            <ol>
                <li class="detailTugas">
                    Melaksanakan

                    @foreach ($tugas as $tg)
                        <span class="fw-bold">{{ $tg }},</span>
                    @endforeach

                    pada hari
                    <?php
                    use Carbon\Carbon;
                    
                    $date = Carbon::parse($surat_tugas->date);
                    $hari = $date->translatedFormat('l');
                    ?>

                    <b>{{ $hari }}</b>, tanggal
                    <b>{{ Carbon::parse($surat_tugas->date)->translatedFormat('d F Y') }}</b>.

                    Pukul <b>{{ $surat_tugas->started_at }} Wib s.d {{ $surat_tugas->finished_at }} Wib.</b>

                    <b>{{ $surat_tugas->tikum }}</b>
                    @if ($surat_tugas->tikum)
                        .
                    @endif

                    Bertempat <b>di {{ $surat_tugas->location }}</b>.

                    Pakaian <b>PDL Lengkap.</b>
                </li>
                <li class="detailTugas">Melaksanakan tugas dengan penuh rasa tanggung jawab.</li>

            </ol>
        </div>

        <div>
            <p style="margin: -10px 0 0 50px;">Surat ini berlaku sejak tanggal dikeluarkan sampai
                dengan
                selesai
                kegiatan dengan ketentuan apabila ternyata terdapat kekeliruan akan diadakan perbaikan
                segera.</p>
            <p style="margin: 5px 0 10px 85px;">Demikian untuk dilaksanakan.</p>
        </div>

        <div style="margin-left: 320px">
            <p style="margin-bottom: 3px;">Dikeluarkan di Palembang
                <br>pada tanggal, {{ Carbon::parse($surat_tugas->tanggal_pembuatan)->translatedFormat('d F Y') }}
            </p>
            @if ($surat_tugas->user->jabatan->detail == 'Kepala Satuan')
                <h6>KEPALA SATUAN POLISI PAMONG PRAJA
                    <br>KOTA PALEMBANG,
                </H6>
                <br><br><br>
                <h6 class="mb-1">{{ $surat_tugas->user->name }}</h6>
                <p class="mb-1">{{ $surat_tugas->user->pangkat->pangkat }} /
                    {{ $surat_tugas->user->pangkat->golongan }}
                </p>
                <p>NIP. {{ $surat_tugas->user->nip }}</p>
            @else
                <h6 class="mb-0">a.n. KEPALA SATUAN POLISI PAMONG PRAJA
                    <br>KOTA PALEMBANG
                </h6>
                <h6 class="text-uppercase">{{ $surat_tugas->user->jabatan->detail }}
                    {{ $surat_tugas->user->jabatan->name }},</h6>
                <br><br><br>
                <h6 class="mb-1">{{ $surat_tugas->user->name }}</h6>
                <p class="mb-1">{{ $surat_tugas->user->pangkat->pangkat }} /
                    {{ $surat_tugas->user->pangkat->golongan }}
                </p>
                <p>NIP. {{ $surat_tugas->user->nip }}</p>
            @endif
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
