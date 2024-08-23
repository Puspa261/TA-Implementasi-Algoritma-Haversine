@extends('layouts.main')
@section('content')
    <style>
        #video {
            width: 50%;
        }

        #canvas {
            width: 35%;
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
        }
    </style>
    <div class="container-xxl  container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ url()->previous() }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Tindak Lanjut</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tanggapi Pengaduan</h5>
                    </div>

                    @if ($errors->any())
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                swal({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Image wajib ada!!!",
                                });
                            });
                        </script>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('tindak_lanjut.store', ['id' => $pengaduan->id]) }}" method="POST"
                            autocomplete="off">
                            @csrf

                            <div class="d-flex flex-column">
                                <label class="form-label" for="video">Buka Camera</label>
                                <video class="mb-2 mt-1 border" id="video" autoplay></video>
                                <a class="btn btn-primary text-white my-1" id="switchCamera">Buka Kamera</a>
                                <a class="btn btn-primary text-white my-1" id="capturePhoto">Ambil Foto</a>
                                <canvas class="border mt-2" id="canvas" name="image" width="1280" height="1280"
                                    style="object-fit: cover"></canvas>
                                <input type="hidden" name="image" id="image">
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label" for="basic-default-fullname">Deskripsi Tanggapan
                                    <span class="star">*</span>
                                </label>
                                <textarea type="text" class="form-control" id="basic-default-fullname" name="detail" required></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4"
                                    href="{{ route('pengaduan_masyarakat.show', $pengaduan->id) }}">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
