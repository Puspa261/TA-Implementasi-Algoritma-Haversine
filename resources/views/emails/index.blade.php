<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-family: Arial, sans-serif; color: black;">
    <h2>{{ $details['title'] }}</h2>
    <p>Halo {{ $details['subtitle'] }},</p>
    <p>Anda Memiliki 1 Pengaduan Baru!</p>
    <p>Nama: {{ $details['nama'] }}</p>
    <!--<p>Telepon: {{ $details['nohp'] }}</p>-->
    <p>Telepon: <a style="text-decoration: none; color: blue;" href="https://wa.me/{{ $details['nohp'] }}?text=Halo,saya yang akan menanggapi pengaduan anda! Mohon ditunggu" target="_blank">{{ $details['nohp'] }}</a></p>
    <p>Pengaduan: {{ $details['message'] }}</p>
    <p>Detail Lokasi: {{ $details['detail'] }}</p>
    <p>Lokasi: {{ $details['lokasi'] }}</p>

    <table role="presentation" style="margin-top: 20px; border-collapse: separate !important; border-spacing: 0;">
        <tr>
            <td style="background-color: rgb(181, 181, 181); padding: 8px 20px; border-radius: 5px; text-align: center;">
                <a href="{{ route('pengaduan_masyarakat.show', $details['pengaduan']) }}" 
                   style="text-decoration: none; color: white; font-weight: bold;">Detail Laporan</a>
            </td>
        </tr>
    </table>
</body>

</html>
