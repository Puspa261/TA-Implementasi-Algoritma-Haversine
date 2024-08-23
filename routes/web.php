<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailReguController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JabatanTugasController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PangkatController;
use App\Http\Controllers\PengaduanMasyarakatController;
use App\Http\Controllers\ReguController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\UserController;
use App\Models\lokasi;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

// CRUD
Route::resource('jabatan', JabatanController::class)->middleware('auth.check');
Route::resource('user', UserController::class)->middleware('auth.check');
Route::resource('role', RoleController::class)->middleware('auth.check');
Route::resource('lokasi', LokasiController::class)->middleware('auth.check');
Route::resource('surat_tugas', SuratTugasController::class)->middleware('auth.check');
Route::resource('jabatan_tugas', JabatanTugasController::class)->middleware('auth.check');
Route::resource('lokasi', LokasiController::class)->middleware('auth.check');
Route::resource('regu', ReguController::class)->middleware('auth.check');
Route::resource('detail_regu', DetailReguController::class)->middleware('auth.check');
Route::resource('pangkat', PangkatController::class)->middleware('auth.check');
Route::resource('pengaduan_masyarakat', PengaduanMasyarakatController::class)->middleware('auth.check');
// Route::post('post-pengaduan',[PengaduanMasyarakatController::class,'store'])->name('penga');
// Route::resource('tindak_lanjut', TindakLanjutController::class)->middleware('auth.check');

// Get Pegawai
Route::get('selectPegawai', [SuratTugasController::class, 'pegawai'])->name('surat_tugas.pegawai')->middleware('auth.check');
Route::get('surat_tugas_pegawai', [SuratTugasController::class, 'st_user'])->name('surat_tugas_pegawai')->middleware('auth.check');
Route::get('surat_tugas_show/{id}', [SuratTugasController::class, 'show_pegawai'])->name('surat_tugas_show')->middleware('auth.check');
Route::get('lokasi-pegawai', [LokasiController::class, 'pegawai'])->name('lokasi.pegawai')->middleware('auth.check');
Route::get('show-lokasi/{id}', [UserController::class, 'show_lokasi'])->name('show.lokasi')->middleware('auth.check');
Route::get('histori-lokasi/{id}', [LokasiController::class, 'histori_lokasi'])->name('histori.lokasi')->middleware('auth.check');

// Tindak Lanjut
Route::get('pengaduan_pegawai', [PengaduanMasyarakatController::class, 'pegawai'])->name('pengaduan.pegawai')->middleware('auth.check');
Route::get('/tindakLanjut/create/{id}', [TindakLanjutController::class, 'create'])->name('tindak_lanjut.create')->middleware('auth.check');
Route::post('tindak_lanjut-post/{id}', [TindakLanjutController::class, 'store'])->name('tindak_lanjut.store')->middleware('auth.check');
Route::get('/pengaduan_masyarakat/{id}', [PengaduanMasyarakatController::class, 'show'])->name('pengaduan_masyarakat.show')->middleware('auth.check');

// Dashboard
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth.check');

// Login
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('map', [SuratTugasController::class, 'map'])->name('map');

// Profile
Route::get('profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth.check');
Route::patch('post-profile', [AuthController::class, 'postProfile'])->name('profile.post')->middleware('auth.check');

// Laporan Masyarakat
Route::get('pengaduan_masyarakat-create', [PengaduanMasyarakatController::class, 'create'])->name('pengaduan_masyarakat.create');
Route::post('pengaduan-post', [PengaduanMasyarakatController::class, 'store'])->name('pengaduan.post');

// Cetak Pengaduan
Route::get('cetak', [PengaduanMasyarakatController::class, 'cetak'])->name('cetak')->middleware('auth.check');
// Route::post('cetak_pengaduan', [PengaduanMasyarakatController::class, 'postCetak'])->name('login.post');

// Dom-PDF
Route::get('surat_tugas_pdf/{id}', [SuratTugasController::class, 'exportPdf'])->name('surat_tugas_pdf')->middleware('auth.check');
Route::get('detail_tugas/{id}', [SuratTugasController::class, 'detail_tugas'])->name('detail_tugas')->middleware('auth.check');

// Dashboard
// Route::get('ditanggapi', [DashboardController::class, 'all'])->name('ditanggapi')->middleware('auth.check');
Route::get('dashboard/all', [DashboardController::class, 'all'])->name('dashboard.all')->middleware('auth.check');
Route::get('dashboard/ditanggapi', [DashboardController::class, 'ditanggapi'])->name('dashboard.ditanggapi')->middleware('auth.check');
Route::get('dashboard/belum_ditanggapi', [DashboardController::class, 'belum_ditanggapi'])->name('dashboard.belum_ditanggapi')->middleware('auth.check');
Route::get('dashboard/pkl', [DashboardController::class, 'pkl'])->name('dashboard.pkl')->middleware('auth.check');
Route::get('dashboard/gepeng', [DashboardController::class, 'gepeng'])->name('dashboard.gepeng')->middleware('auth.check');
Route::get('dashboard/pembangunan', [DashboardController::class, 'pembangunan'])->name('dashboard.pembangunan')->middleware('auth.check');
Route::get('dashboard/parkir', [DashboardController::class, 'parkir'])->name('dashboard.parkir')->middleware('auth.check');
Route::get('dashboard/kebisingan', [DashboardController::class, 'kebisingan'])->name('dashboard.kebisingan')->middleware('auth.check');
Route::get('dashboard/pg_all', [DashboardController::class, 'pg_all'])->name('dashboard.pg_all')->middleware('auth.check');
Route::get('dashboard/pg_ditanggapi', [DashboardController::class, 'pg_ditanggapi'])->name('dashboard.pg_ditanggapi')->middleware('auth.check');
Route::get('dashboard/pg_belum_ditanggapi', [DashboardController::class, 'pg_belum_ditanggapi'])->name('dashboard.pg_belum_ditanggapi')->middleware('auth.check');

// Maps
// Route::get('maps',[SuratTugasController::class,'maps'])->name('maps');
// Route::get('openMaps',[SuratTugasController::class,'openMaps'])->name('openMaps');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('pdf-pages',function(){
//     return view('suratTugas.pdf');
// });

Route::get('/', [PengaduanMasyarakatController::class, 'create'])->name('home');


Route::get('haversine', function () {
    $today = Carbon::now()->toDateString();
    $jarak = lokasi::RangeFrom("-2.9823868", "104.7582729")
        ->whereDate('created_at', $today)
        ->with('pegawai')
        ->orderBy('jarak')
        ->get();

    // dd($jarak);

    // foreach ($jarak->pegawai as $jarak) {
    //     $email = $jarak->email;
    //     $nohp = '+6281274756023';
    //         $details = [
    //             'title' => 'Pengaduan Masyarakat',
    //             // 'subtitle' => 'Halo Saniah,',
    //             // 'p1' => 'Anda memiliki 1 pengaduan baru!'
    //             'nohp' => $nohp,
    //         ];

    //         Mail::to($email)->send(new \App\Mail\Email($details));

    //         dd('berhasil');
    // }

    return response()->json($jarak);
});

// Email
Route::get('send-mail', function () {
    $details = [
        'title' => 'Mail From Puspa Khairunnisa',
        'body' => 'This is For Testing'
    ];

    Mail::to('puspakhairunnisa2626@gmail.com')->send(new \App\Mail\Email($details));
    dd('berhasil');
});

Route::get('clear',function(){
    Artisan::call('optimize:clear');

        // Get the output
        $result = Artisan::output();

        // Return the output as a response
        return response()->json(['result' => $result]);
});
