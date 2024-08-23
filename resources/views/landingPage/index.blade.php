<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Pengaduan Masyarakat</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/images/favicon.png" />

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <!-- Bootstrap core CSS -->
    <link href="landingPage/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="landingPage/assets/css/fontawesome.css">
    <link rel="stylesheet" href="landingPage/assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="landingPage/assets/css/owl.css">
    <link rel="stylesheet" href="landingPage/assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/2.8.0/leaflet-search.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/2.8.0/leaflet-search.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        #video {
            width: 50%;
        }

        #canvas {
            width: 35%;
        }

        * {
            /* border: 1px solid black; */
        }

        .jenis {
            background-color: #8d7dde;
            padding: 15px 18px;
            border: none;
            font-size: 14px;
            color: white;
        }

        .form-select:focus {
            box-shadow: none;
            border: none;
        }

        .image-pengaduan {
            width: 65%;
            height: auto;
        }

        .table-success {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        .field {
            background-color: rgb(181, 181, 181);
        }

        .judul-success {
            font-size: 17px;
            padding: 5px;
            border: 1px solid black;
        }

        .ukuran {
            font-size: 14px;
        }
        
        .word-wrap {
            /*max-width: 150px;*/
            word-wrap: break-word;
            white-space: normal;
        }

        @media (max-width: 410px) {

            * {
                /* border: 1px solid black; */
            }

            #video {
                width: auto;
                height: auto;
            }

            #canvas {
                width: 100%;
            }

            .custom-table th,
            .custom-table td,
            .word-wrap {
                max-width: 200px;
                word-wrap: break-word;
                white-space: normal;
            }
        }
    </style>

</head>

<body>

    @if (session('success'))
        @php
            $jarak = session('jarak');
            $petugas = session('petugas');
        @endphp
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Success!!",
                    icon: "success",
                    html: `
                        @foreach ($petugas->pegawai as $pt)
                            <p style="font-size: 17px;"> Pengaduan telah terkirim ke <b>{{ $pt->name }}</p> </p>
                        @endforeach

                        <table class="table-success">
                        <thead>
                            <tr style="border: 1px solid black;">
                                <th class="judul-success field">No</th>
                                <th class="judul-success field">Nama Petugas</th>
                                <th class="judul-success field">Jarak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jarak as $index => $jr)
                                @foreach ($jr->pegawai as $pg)
                                    <tr style="border: 1px solid black;">
                                        <td class="judul-success" style="font-weight: normal;">{{ $index + 1 }}</td>
                                        <td class="judul-success" style="font-weight: normal;">{{ $pg->name }}</td>
                                        <td class="judul-success" style="font-weight: normal;">{{ $jr->jarak }} km</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        </table>
                    `,
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Wait!!!",
                    icon: "info",
                    html: `
                        <div>Petugas belum ditemukan </br> Tindak lanjut sedikit terhambat</div>
                    `,
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

    @if (session('spam'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Anda sudah mencapai batas pengaduan harian!",
                });
            });
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "{{ $error }}",
                    });
                });
            </script>
        @endforeach
    @endif

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">
                            <h1>Pengaduan</h1>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Serach Start ***** -->
                        <div class="search-input">
                        </div>
                        <!-- ***** Serach Start ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="#laporan">Laporkan</a></li>
                            <li class="scroll-to-section"><a href="#informasi">Informasi</a></li>
                            <li class="scroll-to-section"><a href="{{ route('login') }}">Login</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        <div class="item item-1">
                            <div class="header-text">
                                <span class="category">Pengaduan Online</span>
                                <h2>Pengaduan Masyarakat, Satpol PP Kota Palembang</h2>
                                <p>Merupakan platform online yang memungkinkan masyarakat untuk melaporkan masalah
                                    atau
                                    keluhan terkait
                                    hal yang mengganggu ketentraman dan ketertiban di lingkungan mereka. </p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#laporan">Laporkan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item item-2">
                            <div class="header-text">
                                <span class="category">Pengaduan Online</span>
                                <h2>Mengapa harus di Platform ini?</h2>
                                <p>Platform ini memungkinkan respons cepat dalam penanganan pengaduan karena
                                    terhubung langsung dengan petugas yang sedang bertugas. Petugas akan segera
                                    mendapatkan notifikasi
                                    melalui email saat ada pengaduan baru, memungkinkan mereka untuk langsung
                                    menindaklanjuti pengaduan
                                    tersebut.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#laporan">Laporkan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-us section" id="laporan">
        <div class="container">
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <h4 class="text-white text-center mb-4">Form Pengaduan</h4>
                    <form id="contact-form" action="{{ route('pengaduan.post') }}" method="POST"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">

                            <div class="col-lg-12">
                                <label class="ps-4 text-white fw-bold" for="name">Nama</label>
                                <fieldset>
                                    <input type="text" name="name" id="name" placeholder="Your Name"
                                        required>
                                </fieldset>
                            </div>

                            <div class="col-lg-12">
                                <label class="ps-4 text-white fw-bold" for="phone">Nomor Telepon</label>
                                <fieldset>
                                    <input type="number" name="phone" id="phone" placeholder="Your Number"
                                        required>
                                </fieldset>
                            </div>

                            <div class="col-lg-12 mb-1">
                                <label class="ps-4 text-white fw-bold" for="select">Jenis Pengaduan</label>
                                <fieldset>
                                    <select class="form-select rounded-pill jenis" aria-label="Default select example"
                                        id="select" name="jenis">
                                        <option selected value="">Pilih Jenis Pengaduan</option>
                                        <option value="PK5">Pedagang Kaki Lima (PK5)</option>
                                        <option value="Gepeng">Anak Jalanan dan Pengemis</option>
                                        <option value="Pembangunan">Pembangunan Tanpa Izin</option>
                                        <option value="Parkir">Parkir Liar</option>
                                        <option value="Kebisingan">Kebisingan Malam</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="d-flex flex-column mt-4">
                                <label class="ps-4 text-white fw-bold" for="video">Buka Camera</label>
                                <video class="mb-2 mt-1" id="video" autoplay></video>
                                <a class="btn btn-light mt-2" id="switchCamera">Buka Kamera</a>
                                <a class="btn btn-light my-2" id="capturePhoto">Ambil Foto</a>
                                <canvas class="mb-3 mb-4" id="canvas" name="image" width="1280"
                                    height="1280" style="object-fit: cover"></canvas>
                                <input type="hidden" name="image" id="image">
                            </div>

                            <div class="col-lg-12">
                                <label class="ps-4 text-white fw-bold" for="message">Materi Pengaduan /
                                    Keluhan</label>
                                <fieldset>
                                    <textarea name="message" id="message" placeholder="Your Message" required></textarea>
                                </fieldset>
                            </div>

                            <div class="col-lg-12">
                                <label class="ps-4 text-white fw-bold" for="detail">Detail Lokasi</label>
                                <fieldset>
                                    <input type="text" name="detail" id="detail"
                                        placeholder="Your Detail Location" required>
                                </fieldset>
                            </div>

                            <div class="col-lg-12">
                                <label class="ps-4 text-white fw-bold" for="name-location">Lokasi</label>
                                <fieldset>
                                    <input type="text" name="location" id="name-location" readonly>
                                </fieldset>
                            </div>

                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="text" name="latitude" id="latitude" hidden>
                                </fieldset>
                            </div>

                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="text" name="longitude" id="longitude" hidden>
                                </fieldset>
                            </div>

                            <div class="col-lg-12">
                                <div id="map" class="rounded"></div>
                            </div>

                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="orange-button mt-2">Kirim
                                        Pengaduan</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <div class="contact-us section mb-4" id="informasi">
        <div class="container">
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <h4 class="text-white text-center mb-4">Pengaduan Masyarakat</h4>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered mb-3 custom-table">
                            <thead>
                                <tr style="font-size: 15px;" class="bg-body-secondary">
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Pengaduan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                use Carbon\Carbon;
                                ?>

                                @foreach ($pengaduan_masyarakat as $key => $pm)
                                    <tr style="font-size: 14px;" class="bg-white">
                                        <td class="text-center">{{ ++$i }} </td>
                                        <td class="text-truncate">
                                            @if ($pm->jenis == 'PK5')
                                                <span class="fw-bold">Pedagang Kaki Lima</span>
                                            @elseif ($pm->jenis == 'Gepeng')
                                                <span class="fw-bold">Anak Jalanan dan Pengemis</span>
                                            @elseif ($pm->jenis == 'Pembangunan')
                                                <span class="fw-bold">Pembangunan Tanpa Izin</span>
                                            @elseif ($pm->jenis == 'Parkir')
                                                <span class="fw-bold">Parkir Liar</span>
                                            @elseif ($pm->jenis == 'Kebisingan')
                                                <span class="fw-bold">Kebisingan Malam</span>
                                            @endif
                                            <hr style="margin: 10px 0">

                                            @if ($pm->status == 0)
                                                <span class="text-danger">belum ditanggapi</span>
                                            @else
                                                <span class="text-success">sudah ditanggapi</span>
                                            @endif
                                            <hr style="margin: 10px 0">

                                            {{ Carbon::parse($pm->created_at)->translatedFormat('d F Y / H:i:s') }}
                                            <hr style="margin: 10px 0">

                                            <div class="text-truncate word-wrap">{{ $pm->detail }}
                                            </div>
                                            <hr style="margin: 10px 0">

                                            <div class="text-truncate word-wrap">{{ $pm->message }}
                                            </div>
                                            <hr style="margin: 10px 0">


                                            <button type="button" class="btn btn-primary"
                                                data-id="{{ $pm->id }}" data-image="{{ $pm->image }}"
                                                data-message="{{ $pm->message }}" data-detail="{{ $pm->detail }}"
                                                data-status="{{ $pm->status }}" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" style="font-size: 14px;">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-left pt-2">
                        {!! $pengaduan_masyarakat->render() !!}
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pengaduan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: 14px;">
                                <label for="image">Gambar</label><br>
                                <img id="image" src="" alt="Gambar" class="img-fluid rounded mt-1"
                                    style="width: 75%;"><br>

                                <label class="mt-3" for="message">Materi Pengaduan / Keluhan</label>
                                <input type="text" class="form-control ukuran break-word" id="message" disabled>

                                <label class="mt-3" for="detail">Detail Lokasi</label>
                                <input type="text" class="form-control ukuran break-word" id="detail" disabled>

                                <div id="tindakLanjut" style="margin-top: 25px">
                                    <hr>
                                    <h5>Tindak Lanjut</h5>
                                    <hr>

                                    <label for="tanggalTL">Tanggal Tindakan</label>
                                    <input type="text" class="form-control ukuran break-word" id="tanggalTL"
                                        disabled>

                                    <label class="mt-3" for="gambarTL">Gambar</label><br>
                                    <img id="gambarTL" src="" alt="Tindak Lanjut"
                                        class="img-fluid rounded mt-1" style="width: 75%;"><br>

                                    <label class="mt-3" for="detailTL">Detail Tindak Lanjut</label>
                                    <!--<input type="text" class="form-control ukuran break-word" id="detailTL"-->
                                    <!--    disabled>-->
                                    <textarea class="form-control ukuran break-word" id="detailTL" disabled></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="landingPage/vendor/jquery/jquery.min.js"></script>
    <script src="landingPage/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="landingPage/assets/js/isotope.min.js"></script>
    <script src="landingPage/assets/js/owl-carousel.js"></script>
    <script src="landingPage/assets/js/counter.js"></script>
    <script src="landingPage/assets/js/custom.js"></script>

    <!--Moment.Js untuk tanggal-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>

    {{-- Map --}}
    <script>
        $(document).ready(function() {

            // Map
            var mymap = null;
            var marker = null;
            var searchControl = null;

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    mymap = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(mymap);

                    marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap)
                        .bindPopup('Your current location.', {
                            autoClose: false
                        })
                        .openPopup();

                    // Set nilai otomatis untuk #name-location berdasarkan koordinat saat ini
                    $.getJSON('https://nominatim.openstreetmap.org/reverse?format=json&lat=' +
                        position.coords.latitude + '&lon=' + position.coords.longitude,
                        function(data) {
                            $("#name-location").val(data.display_name);
                        });

                    // Set nilai otomatis untuk latitude dan longitude
                    $("#longitude").val(position.coords.longitude);
                    $("#latitude").val(position.coords.latitude);

                    // Event listener untuk memverifikasi popup tetap terbuka saat klik di tempat lain di peta
                    mymap.on('click', function(e) {
                        marker.bindPopup('Your current location.', {
                            autoClose: false
                        }).openPopup();
                    });
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        })
    </script>

    {{-- Camera --}}
    <script>
        $(document).ready(function() {
            let videoElement = $('#video')[0];
            let canvasElement = $('#canvas')[0];
            let canvasContext = canvasElement.getContext('2d');
            let stream = null;
            let facingMode = 'user'; // Default to front camera

            $('#switchCamera').click(function() {
                if (!stream) {
                    // If the camera is not open, open the front camera
                    openCamera(facingMode);
                    $(this).text('Kamera Belakang');
                } else {
                    // If the camera is open, switch the camera
                    facingMode = (facingMode === 'user') ? 'environment' : 'user'; // Switch camera
                    openCamera(facingMode);
                    $(this).text(facingMode === 'user' ? 'Kamera Belakang' :
                        'Kamera Depan'); // Update button text
                }
            });

            $('#capturePhoto').click(function() {
                capturePhoto();
            });

            async function openCamera(mode) {
                if (stream) {
                    // Stop any active streams before starting a new one
                    stream.getTracks().forEach(track => track.stop());
                }

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: mode,
                            width: 1280,
                            height: 1280
                        }
                    });
                    videoElement.srcObject = stream;
                } catch (error) {
                    console.error("Error opening the camera:", error);
                }
            }

            function capturePhoto() {
                canvasElement.width = 1280;
                canvasElement.height = 1280;

                canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                const imageDataURL = canvasElement.toDataURL('image/png');
                $('#image').val(imageDataURL);
            }
        });
    </script>

    {{-- Modal --}}
    <script>
        $(document).ready(function() {
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var image = button.data('image');
                var message = button.data('message');
                var detail = button.data('detail');
                var id = button.data('id');
                var status = button.data('status');
                // console.log(id);

                if (status == 1) {
                    $.ajax({
                        url: 'api/getTindakLanjut/' + id,
                        type: 'GET',
                        success: function(response) {
                            var tindakLanjut = document.getElementById('tindakLanjut');
                            tindakLanjut.style.display = 'block';
                            modal.find('#gambarTL').attr('src', '/tindak_lanjut/' + response
                                .data.image);
                            modal.find('#detailTL').val(response.data.detail);

                            // Set locale moment.js ke Indonesia
                            moment.locale('id');
                            let formattedDate = moment(response.data.created_at).format(
                                'DD MMMM YYYY / HH:mm:ss');
                            modal.find('#tanggalTL').val(formattedDate);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', status, error);
                            $('#result').html('An error occurred. Please try again.');
                        }
                    });
                } else {
                    document.getElementById('tindakLanjut').style.display = 'none';
                }

                var modal = $(this);
                modal.find('#image').val(image);
                modal.find('#message').val(message);
                modal.find('#detail').val(detail);
                modal.find('#image').attr('src', '/laporan/' + image);


            });
        });
    </script>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
</body>

</html>
